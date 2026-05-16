<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTaskJob;
use App\Models\Call;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VapiWebhookController extends Controller
{
    /**
     * Handle incoming webhooks from Vapi AI.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        $type = $payload['message']['type'] ?? null;
        $callId = $payload['message']['call']['id'] ?? null;

        Log::info("Vapi Webhook Received: {$type}", ['call_id' => $callId]);

        $call = Call::where('call_id', $callId)->first();
        
        if (!$call && $callId) {
            // Fallback: try to find by phone number if outbound
            $phoneNumber = $payload['message']['customer']['number'] ?? null;
            if ($phoneNumber) {
                $user = $this->findUserByPhoneNumber($phoneNumber);
                if ($user) {
                    $call = Call::create([
                        'call_id' => $callId,
                        'user_id' => $user->id,
                        'status' => 'initiated',
                        'direction' => 'inbound'
                    ]);
                }
            }
        }

        switch ($type) {
            case 'assistant.started':
            case 'call-started':
                if ($call) {
                    $call->update(['status' => 'in-progress']);
                    // Tell the browser the call is now live → activate the calling overlay
                    broadcast(new \App\Events\CallProgressUpdated(
                        $call->user_id, 'call_started', 'live', 'in_progress'
                    ));
                }
                break;

            case 'tool-calls':
                $this->handleToolCall($payload, $call);
                break;

            case 'end-of-call-report':
            case 'call-ended':
                if ($call) {
                    $call->update([
                        'status' => 'completed',
                        'duration' => $payload['message']['call']['duration'] ?? 0,
                        'transcript' => $payload['message']['artifact']['transcript'] ?? null,
                        'recording_url' => $payload['message']['artifact']['recordingUrl'] ?? null,
                    ]);

                    // Start background processing of the transcript
                    $this->finalizeOnboardingFromTranscript($call);
                }
                break;

            case 'status-update':
                if ($call) {
                    $call->update(['status' => $payload['message']['status'] ?? 'active']);
                }
                break;
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleToolCall($payload, $call)
    {
        $toolCalls = $payload['message']['toolCalls'] ?? [];
        
        foreach ($toolCalls as $toolCall) {
            if ($toolCall['function']['name'] === 'report_onboarding_data') {
                $args = $toolCall['function']['arguments'] ?? [];
                $field = $args['field'] ?? null;
                $value = $args['value'] ?? null;

                if ($call && $field && $value) {
                    // Save field to call metadata for intermediate tracking
                    $metadata = $call->metadata ?? [];
                    $metadata['extracted_fields'][$field] = $value;
                    $call->update(['metadata' => $metadata]);

                    // Broadcast live update to the frontend
                    broadcast(new \App\Events\CallProgressUpdated(
                        $call->user_id, $field, $value, 'in_progress'
                    ));
                }
            }
        }
    }

    protected function finalizeOnboardingFromTranscript($call)
    {
        $user = $call->user;
        $transcript = $call->transcript;

        if (!$transcript) return;

        // Tell the UI we are now processing the data
        broadcast(new \App\Events\CallProgressUpdated($user->id, 'processing_start', 'Processing your conversation...', 'processing'));

        // Use OpenRouter (DeepSeek) to extract structured data from the transcript
        $prompt = "Extract the following business details from this onboarding transcript. Respond ONLY with a JSON object.
        Fields: business_type, industry, target_audience, experience_level, project_name, project_description, first_task, call_followup_preference (yes/no).
        
        Transcript:
        {$transcript}";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openrouter.api_key'),
            'HTTP-Referer' => config('app.url'),
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'deepseek/deepseek-chat',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'response_format' => ['type' => 'json_object']
        ]);

        if ($response->successful()) {
            $content = $response->json()['choices'][0]['message']['content'];
            $extractedData = json_decode($content, true);
            
            DB::transaction(function() use ($user, $extractedData) {
                try {
                    $profile = $user->profile;

                    $profile->update([
                        'business_type' => $extractedData['business_type'] ?? $profile->business_type,
                        'industry' => $extractedData['industry'] ?? $profile->industry,
                        'target_audience' => $extractedData['target_audience'] ?? $profile->target_audience,
                        'experience_level' => $extractedData['experience_level'] ?? $profile->experience_level,
                        'call_followup_preference' => (isset($extractedData['call_followup_preference']) && strtolower($extractedData['call_followup_preference']) === 'yes'),
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
                    
                    // Final broadcast to redirect user - Include proofread flag
                    $redirectUrl = route('dashboard', ['proofread' => 1]);
                    broadcast(new \App\Events\CallProgressUpdated($user->id, 'complete', $redirectUrl, 'completed'));
                    
                    Log::info("Onboarding finalized for User {$user->id}");
                } catch (\Exception $e) {
                    Log::error("Failed to finalize onboarding: " . $e->getMessage());
                }
            });
        }
    }

    protected function findUserByPhoneNumber($phoneNumber)
    {
        // Clean phone number for matching
        $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        return User::whereHas('profile', function($query) use ($cleanPhone) {
            $query->whereRaw("REPLACE(REPLACE(REPLACE(REPLACE(phone_number, '+', ''), ' ', ''), '-', ''), '(', '') LIKE ?", ["%{$cleanPhone}%"]);
        })->first();
    }
}
