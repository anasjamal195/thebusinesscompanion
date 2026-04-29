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

class VapiWebhookController extends Controller
{
    /**
     * Handle incoming webhooks from Vapi AI.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        $message = $payload['message'] ?? [];
        $type = $message['type'] ?? '';
        $callData = $message['call'] ?? [];
        $callId = $callData['id'] ?? null;

        Log::info("Vapi Webhook Received: {$type}", ['call_id' => $callId]);

        if (!$callId) {
            return response()->json(['status' => 'error', 'message' => 'No call id provided']);
        }

        // Find the call in our database
        $call = Call::where('call_id', $callId)->first();

        switch ($type) {
            case 'call-started':
                if ($call) $call->update(['status' => 'in-progress']);
                break;

            case 'call-ended':
                if ($call) {
                    $call->update([
                        'status' => 'completed',
                        'duration' => ($callData['endedAt'] ?? 0) ? (strtotime($callData['endedAt']) - strtotime($callData['startedAt'])) : 0,
                        'transcript' => $callData['transcript'] ?? null,
                        'recording_url' => $callData['recordingUrl'] ?? null,
                    ]);
                }
                break;

            case 'end-of-call-report':
                $this->processCallReport($message, $call);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Process the end-of-call report and update user data.
     */
    protected function processCallReport(array $message, ?Call $call)
    {
        $callData = $message['call'] ?? [];
        $analysis = $message['analysis'] ?? [];
        
        // Vapi might store variables in assistantOverrides if updated via tools
        // Or we might need to rely on the summary/transcript analysis.
        // For now, let's look for variableValues in the message
        $extractedData = $message['artifact']['variables'] ?? []; // Vapi structure for updated variables
        
        // Identify the user
        $user = $call ? $call->user : $this->findUserByPhoneNumber($callData['customer']['number'] ?? '');

        if (!$user) {
            Log::error("Vapi Webhook: User not found for call report", ['call_id' => $callData['id']]);
            return;
        }

        DB::transaction(function() use ($user, $extractedData, $call, $callData) {
            $profile = $user->profile;

            // Map Vapi variables to profile (assuming they match character prompts)
            $profile->update([
                'business_type' => $extractedData['business_type'] ?? $profile->business_type,
                'industry' => $extractedData['industry'] ?? $profile->industry,
                'target_audience' => $extractedData['target_audience'] ?? $profile->target_audience,
                'experience_level' => $extractedData['experience_level'] ?? $profile->experience_level,
                'current_problems' => $extractedData['current_problems'] ?? $profile->current_problems,
                'urgent_tasks' => $extractedData['urgent_tasks'] ?? $profile->urgent_tasks,
            ]);

            $projectName = $extractedData['project_name'] ?? 'Initial Project';
            
            $project = Project::updateOrCreate(
                ['user_id' => $user->id, 'name' => $projectName],
                [
                    'domain' => $extractedData['project_url'] ?? null,
                    'description' => $extractedData['project_description'] ?? 'Project created via Vapi onboarding call.',
                    'success_metric' => $extractedData['success_metric'] ?? null,
                ]
            );

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
            
            // Update call metadata
            if ($call) {
                $meta = $call->metadata;
                $meta['extracted_data'] = $extractedData;
                $meta['summary'] = $message['analysis']['summary'] ?? null;
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
