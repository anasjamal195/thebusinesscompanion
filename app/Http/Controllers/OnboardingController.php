<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTaskJob;
use App\Models\Project;
use App\Models\Task;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OnboardingController extends Controller
{
    public function role()
    {
        return view('onboarding.role');
    }

    public function business()
    {
        return view('onboarding.business');
    }

    public function character()
    {
        return view('onboarding.character');
    }

    public function saveRole(Request $request)
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'max:255'],
        ]);

        $request->user()->update([
            'role' => $validated['role'],
        ]);

        return redirect()->route('onboarding.business');
    }

    public function saveBusinessInfo(Request $request)
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'target_audience' => ['nullable', 'string'],
            'goals' => ['nullable', 'string'],
            'challenges' => ['nullable', 'string'],
            'experience_level' => ['required', 'in:beginner,intermediate,expert'],
        ]);

        UserProfile::updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated
        );

        return redirect()->route('onboarding.character');
    }

    public function createInitialProjectAndTask(Request $request)
    {
        $validated = $request->validate([
            'character_type' => ['nullable', 'string', 'max:255'],

            'project_name' => ['required', 'string', 'max:255'],
            'project_description' => ['nullable', 'string'],
            'domain' => ['nullable', 'string', 'max:255'],
            'objective' => ['nullable', 'string'],
            'success_metric' => ['nullable', 'string'],

            'task_title' => ['required', 'string', 'max:255'],
            'task_description' => ['required', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
        ]);

        $user = $request->user();
        $profile = $user->profile;

        return DB::transaction(function () use ($validated, $user, $profile) {
            if (!empty($validated['character_type'])) {
                $user->character_type = $validated['character_type'];
            }

            $project = Project::create([
                'user_id' => $user->id,
                'name' => $validated['project_name'],
                'description' => $validated['project_description'] ?? null,
                'domain' => $validated['domain'] ?? null,
                'objective' => $validated['objective'] ?? null,
                'success_metric' => $validated['success_metric'] ?? null,
            ]);

            $context = [
                'user' => [
                    'role' => $user->role,
                    'character_type' => $user->character_type,
                ],
                'business' => $profile ? [
                    'business_name' => $profile->business_name,
                    'business_type' => $profile->business_type,
                    'industry' => $profile->industry,
                    'target_audience' => $profile->target_audience,
                    'goals' => $profile->goals,
                    'challenges' => $profile->challenges,
                    'experience_level' => $profile->experience_level,
                ] : null,
                'project' => [
                    'name' => $project->name,
                    'description' => $project->description,
                    'domain' => $project->domain,
                    'objective' => $project->objective,
                    'success_metric' => $project->success_metric,
                ],
                'task' => [
                    'title' => $validated['task_title'],
                    'input_text' => $validated['task_description'],
                    'priority' => $validated['priority'],
                ],
            ];

            $task = Task::create([
                'project_id' => $project->id,
                'user_id' => $user->id,
                'title' => $validated['task_title'],
                'input_text' => $validated['task_description'],
                'priority' => $validated['priority'],
                'status' => 'pending',
                'context_snapshot' => $context,
            ]);

            $user->onboarding_completed = true;
            $user->save();

            ProcessTaskJob::dispatch($task->id);

            return redirect()->route('projects.show', $project);
        });
    }
}
