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
        $todayStr    = $now->toDateString();

        $this->line("[User {$user->id}] timezone={$user->timezone} now={$now->format('Y-m-d H:i:s')} today={$todayStr} morning_time={$morningTime->format('H:i')} last_morning_date={$user->last_morning_call_date} last_call={$user->last_call_time}");

        // ── 1. MORNING CALL (only when no morning call yet, time is right, and no tasks exist) ──
        $needsMorningCall = $user->last_morning_call_date !== $todayStr;

        $this->line("[User {$user->id}] needsMorningCall=".($needsMorningCall?'true':'false')." now>=morningTime=".($now->greaterThanOrEqualTo($morningTime)?'true':'false'));

        if ($needsMorningCall && $now->greaterThanOrEqualTo($morningTime)) {
            $todayTasks = $this->getTodayPendingTasks($user);

            $this->line("[User {$user->id}] morning branch: tasks_today=".$todayTasks->count());

            if ($todayTasks->isEmpty()) {
                $this->info("Triggering morning call for User {$user->id} ({$user->name})");
                $result = $this->vapi->createCall($user, 'morning', $todayTasks);

                if ($result) {
                    $user->update([
                        'last_morning_call_date' => $todayStr,
                        'last_call_time'         => now('UTC')->toDateTimeString(),
                    ]);
                    $this->line("[User {$user->id}] morning call initiated, set last_morning_call_date={$todayStr}");
                } else {
                    $this->error("[User {$user->id}] morning call FAILED");
                }

                return; // Wait for morning call to complete
            }

            $this->line("[User {$user->id}] tasks exist — skipping morning call, falling through to follow-up");
        }

        // ── 2. FOLLOW-UP CALLS ────────────────────────────────────────────
        $pendingTasks = $this->getTodayPendingTasks($user);

        $this->line("[User {$user->id}] follow-up: pending_tasks=".$pendingTasks->count()." default_delay=".($user->default_delay_minutes ?? 'null'));

        if ($pendingTasks->isEmpty()) {
            $this->line("[User {$user->id}] no pending tasks — nothing to do");
            return;
        }

        // Always check AI-estimated mode first: any task's scheduled_followup_time elapsed?
        $dueTasks = $pendingTasks->filter(function (Task $t) use ($user) {
                $isDue = $t->scheduled_followup_time
                    && Carbon::parse($t->scheduled_followup_time, 'UTC')->lessThanOrEqualTo(now('UTC'));
                $this->line("[User {$user->id}]   task #{$t->id} '{$t->title}' sft={$t->scheduled_followup_time} isDue=".($isDue?'true':'false'));
                return $isDue;
            });

        $this->line("[User {$user->id}] AI-estimated: due_tasks=".$dueTasks->count());

        $shouldCall = $dueTasks->isNotEmpty();

        // If default_delay_minutes is set, enforce it as a minimum gap since last call
        if ($shouldCall && $user->default_delay_minutes) {
            $lastCall   = $user->last_call_time ? Carbon::parse($user->last_call_time, 'UTC') : now('UTC')->startOfDay();
            $nextCallAt = $lastCall->copy()->addMinutes($user->default_delay_minutes);

            $this->line("[User {$user->id}] min-gap={$user->default_delay_minutes}min: last_call={$lastCall->format('Y-m-d H:i:s')} next_allowed={$nextCallAt->format('Y-m-d H:i:s')} now_utc=".now('UTC')->format('Y-m-d H:i:s'));

            if (now('UTC')->lessThan($nextCallAt)) {
                $this->line("[User {$user->id}] blocked by min-gap — {$nextCallAt->format('H:i')} not reached yet");
                $shouldCall = false;
            }
        }

        if ($shouldCall) {
            // Push due tasks' follow-up times ahead to avoid re-triggering before next call
            foreach ($dueTasks as $task) {
                $task->update(['scheduled_followup_time' => now()->addMinutes(60)]);
                $this->line("[User {$user->id}]   pushed task #{$task->id} followup to +60min");
            }

            $this->info("Triggering follow-up call for User {$user->id} ({$user->name})");
            $this->vapi->createCall($user, 'followup', $pendingTasks);
            $user->update(['last_call_time' => now('UTC')->toDateTimeString()]);
        } else {
            $this->line("[User {$user->id}] shouldCall=false — not triggering follow-up");
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
