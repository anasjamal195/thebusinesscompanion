<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTaskJob;
use App\Models\Call;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RetellWebhookController extends Controller
{
    /**
     * Handle incoming webhooks from Retell AI.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        $event = $payload['event'] ?? '';
        $callData = $payload['call'] ?? [];
        $callId = $callData['call_id'] ?? null;

        Log::info("Retell Webhook Received: {$event}", ['call_id' => $callId]);

        if (!$callId) {
            return response()->json(['status' => 'error', 'message' => 'No call_id provided']);
        }

        // Find the call in our database
        $call = Call::where('call_id', $callId)->first();

        // If it's an inbound call we don't know about yet, we might need a different lookup logic
        // But for this task, we focus on outbound onboarding calls.

        switch ($event) {
            case 'call_started':
                if ($call) $call->update(['status' => 'in-progress']);
                break;

            case 'call_ended':
                if ($call) {
                    $call->update([
                        'status' => 'completed',
                        'duration' => $callData['duration_ms'] / 1000,
                        'transcript' => $callData['transcript'] ?? null,
                        'recording_url' => $callData['recording_url'] ?? null,
                    ]);
                }
                break;

            case 'call_analyzed':
                $this->processCallAnalysis($callData, $call);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Process the analyzed call data and update the user's profile/projects.
     */
    protected function processCallAnalysis(array $callData, ?Call $call)
    {
        $extractedData = $callData['retell_llm_extracted_variables'] ?? [];
        
        // Identify the user
        $user = $call ? $call->user : $this->findUserByPhoneNumber($callData['to_number']);

        if (!$user) {
            Log::error("Retell Webhook: User not found for call analysis", ['call_id' => $callData['call_id']]);
            return;
        }

        DB::transaction(function() use ($user, $extractedData, $call) {
            $profile = $user->profile;

            // Update Profile
            $profile->update([
                'business_type' => $extractedData['business_type'] ?? $profile->business_type,
                'industry' => $extractedData['industry'] ?? $profile->industry,
                'target_audience' => $extractedData['target_audience'] ?? $profile->target_audience,
                'experience_level' => $extractedData['experience_level'] ?? $profile->experience_level,
                'current_problems' => $extractedData['current_problems'] ?? $profile->current_problems,
                'urgent_tasks' => $extractedData['urgent_tasks'] ?? $profile->urgent_tasks,
            ]);

            // Only create project if one doesn't exist for this name, or handle differently
            $projectName = $extractedData['project_name'] ?? 'Initial Project';
            
            $project = Project::create([
                'user_id' => $user->id,
                'name' => $projectName,
                'domain' => $extractedData['project_url'] ?? null,
                'description' => $extractedData['project_description'] ?? 'Project created via onboarding call.',
                'success_metric' => $extractedData['success_metric'] ?? null,
            ]);

            // Create Initial Task
            if (!empty($extractedData['current_problems']) || !empty($extractedData['urgent_tasks'])) {
                $task = Task::create([
                    'project_id' => $project->id,
                    'user_id' => $user->id,
                    'title' => 'Initial Assessment',
                    'input_text' => "Current Problems: " . ($extractedData['current_problems'] ?? 'None') . "\nUrgent Tasks: " . ($extractedData['urgent_tasks'] ?? 'None'),
                    'priority' => 'high',
                    'status' => 'pending',
                ]);

                ProcessTaskJob::dispatch($task->id);
            }

            // Mark onboarding as completed
            $user->update(['onboarding_completed' => true]);
            
            // Update call metadata with extraction results
            if ($call) {
                $meta = $call->metadata;
                $meta['extracted_data'] = $extractedData;
                $call->update(['metadata' => $meta]);
            }
        });
    }

    protected function findUserByPhoneNumber(string $phoneNumber): ?User
    {
        return User::whereHas('profile', function($query) use ($phoneNumber) {
            $query->where('phone_number', 'LIKE', '%' . substr($phoneNumber, -10));
        })->first();
    }
}
