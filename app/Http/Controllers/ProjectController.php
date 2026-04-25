<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->onboarding_completed) {
            return redirect()->route('onboarding.role');
        }

        $projects = Project::query()
            ->where('user_id', $request->user()->id)
            ->latest('id')
            ->get();

        return view('dashboard', [
            'projects' => $projects,
            'title' => 'Dashboard',
            'pageTitle' => 'Dashboard',
            'activeNav' => 'dashboard',
        ]);
    }

    public function show(Request $request, Project $project)
    {
        abort_unless($project->user_id === $request->user()->id, 404);

        $taskId = $request->query('task');

        $tasksQuery = $project->tasks()
            ->where('user_id', $request->user()->id)
            ->with('output')
            ->latest('id');

        if ($taskId) {
            $tasksQuery->where('id', (int) $taskId);
        } else {
            $tasksQuery->limit(15);
        }

        $tasks = $tasksQuery->get()->reverse()->values();

        $messages = collect();
        foreach ($tasks as $t) {
            $messages->push((object) [
                'role' => 'user',
                'content' => (string) $t->input_text,
            ]);
            if ($t->output) {
                $messages->push((object) [
                    'role' => 'assistant',
                    'content' => (string) $t->output->output_text,
                ]);
            }
        }

        return view('projects.show', [
            'project' => $project,
            'messages' => $messages,
            'title' => 'Project',
            'pageTitle' => $project->name,
            'activeNav' => 'projects',
            'activeProjectId' => (string) $project->id,
            'activeTaskId' => $taskId ? (string) $taskId : null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'domain' => ['nullable', 'string', 'max:255'],
            'objective' => ['nullable', 'string'],
            'success_metric' => ['nullable', 'string'],
        ]);

        $project = Project::create([
            'user_id' => $request->user()->id,
            ...$validated,
        ]);

        return redirect()->route('projects.show', $project);
    }
}
