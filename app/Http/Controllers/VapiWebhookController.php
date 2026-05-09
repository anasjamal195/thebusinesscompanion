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
        if (!$call) {
            Log::warning("Vapi Webhook: Call record not found in DB", ['call_id' => $callId]);
        }

        switch ($type) {
            case 'call-started':
                if ($call) $call->update(['status' => 'in-progress']);
                break;

            case 'tool-calls':
                $this->handleToolCalls($message, $call);
                break;

            case 'call-ended':
                if ($call) {
                    $call->update([
                        'status' => 'completed',
                        'duration' => ($callData['endedAt'] ?? 0) ? (strtotime($callData['endedAt']) - strtotime($callData['startedAt'])) : 0,
                        'transcript' => $callData['transcript'] ?? null,
                        'recording_url' => $callData['recordingUrl'] ?? null,
                    ]);
                    
                    // Fire final processing if it was an onboarding call
                    if (($call->metadata['task_type'] ?? '') === 'onboarding') {
                        $this->finalizeOnboardingFromTranscript($call);
                    }
                }
                break;
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle live tool calls from Vapi.
     */
    protected function handleToolCalls(array $message, ?Call $call)
    {
        $toolCalls = $message['toolCalls'] ?? [];
        foreach ($toolCalls as $toolCall) {
            if ($toolCall['function']['name'] === 'report_onboarding_data') {
                $args = json_decode($toolCall['function']['arguments'], true);
                $field = $args['field'] ?? null;
                $value = $args['value'] ?? null;

                if ($field && $call) {
                    // Save to call metadata for tracking
                    $meta = $call->metadata;
                    $meta['live_extracted_data'][$field] = $value;
                    $call->update(['metadata' => $meta]);

                    // Broadcast live update
                    broadcast(new \App\Events\CallProgressUpdated($call->user_id, $field, $value, 'in_progress'));
                }
            }
        }
    }

    /**
     * Finalize onboarding by processing the full transcript with an LLM.
     */
    protected function finalizeOnboardingFromTranscript(Call $call)
    {
        $user = $call->user;
        $transcript = $call->transcript;

        if (!$transcript || !$user) return;

        // Use LLM to extract all fields from transcript
        $prompt = "Extract the following onboarding information from the business companion call transcript below. " .
                  "Fields to extract: business_type, industry, target_audience, experience_level, project_name, project_description, first_task, call_followup_preference. " .
                  "Return ONLY a valid JSON object with these keys. If a field is missing, use null.\n\n" .
                  "Transcript:\n" . $transcript;

        $response = Http::withToken(config('services.openrouter.api_key'))
            ->post(config('services.openrouter.base_url') . '/chat/completions', [
                'model' => config('services.openrouter.model'),
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'response_format' => ['type' => 'json_object']
            ]);

        if ($response->successful()) {
            $extractedData = json_decode($response->json()['choices'][0]['message']['content'], true);
            
            DB::transaction(function() use ($user, $extractedData, $call) {
                $profile = $user->profile;

                $profile->update([
                    'business_type' => $extractedData['business_type'] ?? $profile->business_type,
                    'industry' => $extractedData['industry'] ?? $profile->industry,
                    'target_audience' => $extractedData['target_audience'] ?? $profile->target_audience,
                    'experience_level' => $extractedData['experience_level'] ?? $profile->experience_level,
                    'call_followup_preference' => $extractedData['call_followup_preference'] ?? null,
                ]);

                $project = Project::updateOrCreate(
                    ['user_id' => $user->id, 'name' => $extractedData['project_name'] ?? 'Initial Project'],
                    [
                        'description' => $extractedData['project_description'] ?? 'Project created via voice onboarding.',
                    ]
                );

                if (!empty($extractedData['first_task'])) {
                    $task = Task::create([
                        'project_id' => $project->id,
                        'user_id' => $user->id,
                        'title' => 'Initial Task',
                        'input_text' => $extractedData['first_task'],
                        'priority' => 'high',
                        'status' => 'pending',
                    ]);

                    \App\Jobs\ProcessTaskJob::dispatch($task->id);
                }

                $user->update(['onboarding_completed' => true]);
                
                // Final broadcast to redirect user - Include task ID if created
                $redirectUrl = $project->id . (isset($task) ? '?task=' . $task->id : '');
                broadcast(new \App\Events\CallProgressUpdated($user->id, 'complete', $redirectUrl, 'completed'));
            });
        }
    }

    protected function findUserByPhoneNumber(string $phoneNumber): ?User
    {
        return User::whereHas('profile', function($query) use ($phoneNumber) {
            $query->where('phone_number', 'LIKE', '%' . substr($phoneNumber, -10));
        })->first();
    }

    protected function findUserByPhoneNumber(string $phoneNumber): ?User
    {
        return User::whereHas('profile', function($query) use ($phoneNumber) {
            $query->where('phone_number', 'LIKE', '%' . substr($phoneNumber, -10));
        })->first();
    }
}
