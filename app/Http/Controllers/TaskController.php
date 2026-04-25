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

        ProcessTaskJob::dispatch($task->id);

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
}
