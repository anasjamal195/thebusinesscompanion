<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTaskJob;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'input_text' => ['required', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
        ]);

        $project = Project::query()->findOrFail($validated['project_id']);
        abort_unless($project->user_id === $request->user()->id, 404);

        $user = $request->user()->loadMissing('profile');

        // Check if there is a task waiting for input
        $waitingTask = Task::where('project_id', $project->id)
            ->where('status', 'waiting_input')
            ->where('user_id', $user->id)
            ->first();

        if ($waitingTask) {
            $inputs = $waitingTask->user_inputs ?? [];
            $inputs['user_reply_' . time()] = $validated['input_text'];
            
            $waitingTask->update([
                'user_inputs' => $inputs,
                'status' => 'processing',
            ]);

            try {
                \Illuminate\Support\Facades\Http::post('http://127.0.0.1:5002/process-task', [
                    'task_id' => $waitingTask->id,
                    'webhook_url' => url('/api/tasks/webhook-process'),
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Python runner error: ' . $e->getMessage());
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'task' => [
                        'id' => $waitingTask->id,
                        'title' => $waitingTask->title,
                        'input_text' => $waitingTask->input_text,
                        'priority' => $waitingTask->priority,
                        'status' => $waitingTask->status,
                    ],
                ]);
            }
            return back();
        }

        $context = [
            'user' => [
                'role' => $user->role,
                'character_type' => $user->character_type,
            ],
            'business' => $user->profile ? [
                'business_name' => $user->profile->business_name,
                'business_type' => $user->profile->business_type,
                'industry' => $user->profile->industry,
                'target_audience' => $user->profile->target_audience,
                'goals' => $user->profile->goals,
                'challenges' => $user->profile->challenges,
                'experience_level' => $user->profile->experience_level,
            ] : null,
            'project' => [
                'name' => $project->name,
                'description' => $project->description,
                'domain' => $project->domain,
                'objective' => $project->objective,
                'success_metric' => $project->success_metric,
            ],
            'task' => [
                'title' => $validated['title'],
                'input_text' => $validated['input_text'],
                'priority' => $validated['priority'],
            ],
        ];

        $task = DB::transaction(function () use ($validated, $request, $project, $context) {
            return Task::create([
                'project_id' => $project->id,
                'user_id' => $request->user()->id,
                'title' => $validated['title'],
                'input_text' => $validated['input_text'],
                'priority' => $validated['priority'],
                'status' => 'pending',
                'context_snapshot' => $context,
            ]);
        });

        // Start multithreading via Python script
        try {
            \Illuminate\Support\Facades\Http::post('http://127.0.0.1:5002/process-task', [
                'task_id' => $task->id,
                'webhook_url' => url('/api/tasks/webhook-process'),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Python runner error: ' . $e->getMessage());
        }

        if ($request->expectsJson()) {
            return response()->json([
                'task' => [
                    'id' => $task->id,
                    'title' => $task->title,
                    'input_text' => $task->input_text,
                    'priority' => $task->priority,
                    'status' => $task->status,
                ],
            ]);
        }

        return back();
    }

    public function getByProject(Request $request, Project $project)
    {
        abort_unless($project->user_id === $request->user()->id, 404);

        $tasks = $project->tasks()
            ->with(['output', 'report'])
            ->latest('id')
            ->limit(30)
            ->get()
            ->reverse()
            ->values();

        return response()->json([
            'tasks' => $tasks->map(function (Task $task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'input_text' => $task->input_text,
                    'priority' => $task->priority,
                    'status' => $task->status,
                    'output' => $task->output ? [
                        'output_text' => $task->output->output_text,
                    ] : null,
                    'report' => $task->report ? [
                        'id' => $task->report->id,
                        'summary' => $task->report->summary,
                    ] : null,
                    'created_at' => $task->created_at?->toISOString(),
                ];
            })->all(),
        ]);
    }

    public function provideInput(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 404);

        $validated = $request->validate([
            'message' => ['required', 'string'],
        ]);

        if ($task->status === 'waiting_input') {
            $inputs = $task->user_inputs ?? [];
            $inputs['user_reply_' . time()] = $validated['message'];
            
            $task->update([
                'user_inputs' => $inputs,
                'status' => 'processing',
            ]);

            // Inform Python runner to continue
            try {
                \Illuminate\Support\Facades\Http::post('http://127.0.0.1:5002/process-task', [
                    'task_id' => $task->id,
                    'webhook_url' => url('/api/tasks/webhook-process'),
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Python runner error: ' . $e->getMessage());
            }

            return response()->json(['status' => 'processing']);
        }

        return response()->json(['status' => 'error', 'message' => 'Task is not waiting for input.'], 400);
    }
}
