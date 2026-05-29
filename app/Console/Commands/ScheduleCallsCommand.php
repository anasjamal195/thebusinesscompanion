<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Services\VapiService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleCallsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'calls:schedule';

    /**
     * The console command description.
     */
    protected $description = 'Trigger morning and follow-up calls for users based on their schedule';

    public function __construct(protected VapiService $vapi)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereNotNull('morning_call_time')->get();

        $this->info("Checking {$users->count()} user(s)...");

        foreach ($users as $user) {
            $this->processUser($user);
        }

        $this->info('Done.');
    }

    protected function processUser(User $user): void
    {
        $now         = now()->setTimezone($user->timezone);
        $morningTime = Carbon::createFromFormat('H:i:s', $user->morning_call_time, $user->timezone);

        // ── 1. MORNING CALL ───────────────────────────────────────────────
        if ($user->last_morning_call_date !== $now->toDateString()) {
            if ($now->greaterThanOrEqualTo($morningTime)) {
                $todayTasks = $this->getTodayPendingTasks($user);

                $this->info("Triggering morning call for User {$user->id} ({$user->name})");
                $this->vapi->createCall($user, 'morning', $todayTasks);

                $user->update([
                    'last_morning_call_date' => $now->toDateString(),
                    'last_call_time'         => now('UTC')->toDateTimeString(),
                ]);

                return; // No follow-ups until morning call is done
            }

            // Morning time hasn't arrived yet — nothing to do
            return;
        }

        // ── 2. FOLLOW-UP CALLS ────────────────────────────────────────────
        $pendingTasks = $this->getTodayPendingTasks($user);

        if ($pendingTasks->isEmpty()) {
            return; // All done for today 🎉
        }

        $shouldCall = false;

        if ($user->default_delay_minutes) {
            // Fixed interval mode: calls come every N minutes starting from morning call
            $lastCall    = $user->last_call_time ? Carbon::parse($user->last_call_time, 'UTC') : now('UTC')->startOfDay();
            $nextCallAt  = $lastCall->copy()->addMinutes($user->default_delay_minutes);

            if (now('UTC')->greaterThanOrEqualTo($nextCallAt)) {
                $shouldCall = true;
            }
        } else {
            // AI-estimated mode: call when any task's scheduled_followup_time has elapsed
            $dueTasks = $pendingTasks->filter(
                fn (Task $t) => $t->scheduled_followup_time
                    && Carbon::parse($t->scheduled_followup_time, 'UTC')->lessThanOrEqualTo(now('UTC'))
            );

            if ($dueTasks->isNotEmpty()) {
                $shouldCall = true;

                // Push those tasks' follow-up times ahead to avoid re-triggering before next call
                foreach ($dueTasks as $task) {
                    $task->update(['scheduled_followup_time' => now()->addMinutes(60)]);
                }
            }
        }

        if ($shouldCall) {
            $this->info("Triggering follow-up call for User {$user->id} ({$user->name})");
            $this->vapi->createCall($user, 'followup', $pendingTasks);
            $user->update(['last_call_time' => now('UTC')->toDateTimeString()]);
        }
    }

    protected function getTodayPendingTasks(User $user)
    {
        return Task::where('user_id', $user->id)
            ->where('date', now()->setTimezone($user->timezone)->toDateString())
            ->where('status', 'pending')
            ->get();
    }
}
