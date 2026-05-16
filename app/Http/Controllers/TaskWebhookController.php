<?php

namespace App\Http\Controllers;

use App\Events\TaskCompleted;
use App\Models\Task;
use App\Services\ReportService;
use App\Services\TaskExecutionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskWebhookController extends Controller
{
    public function process(Request $request, TaskExecutionService $executor, ReportService $reportService)
    {
        $request->validate([
            'task_id' => 'required|integer',
        ]);

        $task = Task::with(['user.profile', 'project', 'output', 'report'])->findOrFail($request->task_id);

        if ($task->status === 'completed' || $task->status === 'error') {
            return response()->json(['status' => $task->status]);
        }

        if ($task->status === 'waiting_input') {
            return response()->json(['status' => 'waiting_input']);
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

            // If we don't have a plan yet, generate one
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
                    
                    // We can emit an event here to notify UI
                    broadcast(new \App\Events\TaskStatusUpdated($task))->toOthers();
                    
                    return response()->json(['status' => 'waiting_input']);
                }
            }

            // We have a plan and no pending inputs (or inputs were provided). Let's execute.
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
                broadcast(new \App\Events\TaskStatusUpdated($fresh))->toOthers();
            } catch (\Throwable $e) {
                // ignore
            }

            return response()->json(['status' => 'completed']);

        } catch (\Throwable $e) {
            Log::error('TaskWebhookController failed.', [
                'task_id' => $task->id,
                'error' => $e->getMessage(),
            ]);

            DB::transaction(function () use ($task) {
                $task->update(['status' => 'error']);
            });
            broadcast(new \App\Events\TaskStatusUpdated($task->fresh()))->toOthers();

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
