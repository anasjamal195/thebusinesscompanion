<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('task:process {taskId}')]
#[Description('Process a task asynchronously')]
class ProcessTaskCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(\App\Services\TaskExecutionService $executor, \App\Services\ReportService $reportService)
    {
        $taskId = $this->argument('taskId');
        $task = \App\Models\Task::with(['user.profile', 'project', 'output', 'report'])->findOrFail($taskId);

        if ($task->status === 'completed' || $task->status === 'error') {
            return;
        }

        try {
            $character = null;
            if ($task->user->character_type) {
                $character = \App\Models\AiCharacter::query()->where('key', $task->user->character_type)->first();
            }

            $recentTasks = \App\Models\Task::query()
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

            // If we don't have a plan yet, generate one
            if (empty($task->plan_data)) {
                \Illuminate\Support\Facades\DB::transaction(function () use ($task) {
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
                    broadcast(new \App\Events\TaskStatusUpdated($task))->toOthers();
                    return;
                }
            }

            // Execute the plan
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

            \Illuminate\Support\Facades\DB::transaction(function () use ($task, $outputText, $structured, $reportService) {
                $task->output()->updateOrCreate(
                    ['task_id' => $task->id],
                    ['output_text' => $outputText, 'structured_data' => $structured]
                );

                $task->update(['status' => 'completed']);
                $reportService->generateFromTask($task->fresh('output'));
            });

            $fresh = $task->fresh(['report']);
            try {
                broadcast(new \App\Events\TaskCompleted(
                    $fresh,
                    $outputText,
                    $structured,
                    $fresh->report?->id
                ));
                broadcast(new \App\Events\TaskStatusUpdated($fresh))->toOthers();
            } catch (\Throwable $e) {
                // ignore
            }

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('ProcessTaskCommand failed.', [
                'task_id' => $task->id,
                'error' => $e->getMessage(),
            ]);

            \Illuminate\Support\Facades\DB::transaction(function () use ($task) {
                $task->update(['status' => 'error']);
            });
            broadcast(new \App\Events\TaskStatusUpdated($task->fresh()))->toOthers();
        }
    }
}
