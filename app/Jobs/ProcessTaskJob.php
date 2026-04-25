<?php

namespace App\Jobs;

use App\Events\TaskCompleted;
use App\Models\Task;
use App\Services\ReportService;
use App\Services\TaskExecutionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessTaskJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 480;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly int $taskId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(TaskExecutionService $executor, ReportService $reportService): void
    {
        $task = Task::with(['user.profile', 'project', 'output', 'report'])
            ->findOrFail($this->taskId);

        DB::transaction(function () use ($task) {
            $task->update(['status' => 'processing']);
        });

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

        try {
            $character = null;
            if ($task->user->character_type) {
                $character = \App\Models\AiCharacter::query()->where('key', $task->user->character_type)->first();
            }

            $result = $executor->executeStructured(
                $task,
                $task->user,
                $task->user->profile,
                $task->project,
                $recentTasks,
                $character,
                log: function (string $step, string $message, string $status) use ($executor, $task) {
                    $executor->persistLog($task, $step, $message, $status);
                }
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
            } catch (\Throwable $e) {
                // ignore
            }
        } catch (\Throwable $e) {
            Log::error('ProcessTaskJob failed.', [
                'task_id' => $task->id,
                'error' => $e->getMessage(),
            ]);

            DB::transaction(function () use ($task) {
                $task->update(['status' => 'pending']);
            });

            throw $e;
        }
    }
}
