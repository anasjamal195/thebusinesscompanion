<?php

namespace App\Console\Commands;

use App\Events\TaskCompleted;
use App\Models\Task;
use App\Services\ReportService;
use App\Services\TaskExecutionService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

#[Signature('task:process {task_id}')]
#[Description('Process a task via CLI to bypass HTTP timeouts')]
class ProcessTaskCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(TaskExecutionService $executor, ReportService $reportService)
    {
        $taskId = $this->argument('task_id');
        $task = Task::with(['user.profile', 'project', 'output', 'report'])->findOrFail($taskId);

        if ($task->status === 'completed' || $task->status === 'error') {
            $this->info("Task is already {$task->status}.");
            return 0;
        }

        if ($task->status === 'waiting_input') {
            $this->info("Task is waiting for input.");
            return 0;
        }

        try {
            $character = null;
            if ($task->user->character_type) {
                $character = \App\Models\AiCharacter::query()->where('key', $task->user->character_type)->first();
            }

            $recentTasks = Task::query()
                ->where('project_id', $task->project_id)
                ->where('id', '!=', $task->id)
                ->with('output')
                ->latest('id')
                ->limit(5)
                ->get()
                ->map(fn ($t) => [
                    'title' => $t->title,
                    'status' => $t->status,
                    'output' => optional($t->output)->output_text,
                ])
                ->all();

            $logFunc = function (string $step, string $message, string $status) use ($executor, $task) {
                $executor->persistLog($task, $step, $message, $status);
            };

            // Phase 1: Planning
            if (empty($task->plan_data)) {
                DB::transaction(function () use ($task) {
                    $task->update(['status' => 'processing']);
                });
                
                $plan = $executor->createPlanAndIdentifyInputs(
                    $task,
                    $task->user,
                    $task->user->profile,
                    $task->project,
                    $recentTasks,
                    $character,
                    $logFunc
                );

                $task->update(['plan_data' => $plan]);

                if (!empty($plan['required_inputs']) && empty($task->user_inputs)) {
                    $task->update(['status' => 'waiting_input']);
                    broadcast(new \App\Events\TaskStatusUpdated($task));
                    $this->info("Task needs user input.");
                    return 0;
                }
            }

            // Phase 2: Execution
            $result = $executor->executePrePlannedTask(
                $task,
                $task->user,
                $task->user->profile,
                $task->project,
                $recentTasks,
                $character,
                $task->plan_data,
                $task->user_inputs,
                $logFunc
            );

            $outputText = $result['final_text'];
            $structured = $result['structured'];

            DB::transaction(function () use ($task, $outputText, $structured, $reportService) {
                $task->output()->updateOrCreate(
                    ['task_id' => $task->id],
                    ['output_text' => $outputText, 'structured_data' => $structured]
                );

                $task->update(['status' => 'completed']);
                $reportService->generateFromTask($task->fresh('output'));
            });

            $fresh = $task->fresh(['report']);
            try {
                broadcast(new TaskCompleted(
                    $fresh,
                    $outputText,
                    $structured,
                    $fresh->report?->id
                ));
                broadcast(new \App\Events\TaskStatusUpdated($fresh));
            } catch (\Throwable $e) {
                // ignore
            }

            $this->info("Task completed successfully.");
            return 0;

        } catch (\Throwable $e) {
            Log::error('ProcessTaskCommand failed.', [
                'task_id' => $task->id,
                'error' => $e->getMessage(),
            ]);

            DB::transaction(function () use ($task) {
                $task->update(['status' => 'error']);
            });
            broadcast(new \App\Events\TaskStatusUpdated($task->fresh()));

            $this->error("Task failed: " . $e->getMessage());
            return 1;
        }
    }
}
