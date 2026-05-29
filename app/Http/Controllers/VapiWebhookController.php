<?php

namespace App\Http\Controllers;

use App\Models\Call;
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
        
        // Find local_call_id in various possible locations in Vapi payload
        $localCallId = $payload['message']['call']['metadata']['local_call_id'] 
            ?? $payload['message']['metadata']['local_call_id']
            ?? $payload['message']['call']['assistantOverrides']['metadata']['local_call_id']
            ?? $payload['message']['call']['assistantOverrides']['variableValues']['local_call_id']
            ?? null;

        if (!$localCallId) {
            Log::warning("Vapi Webhook: local_call_id not found in payload.", ['payload' => $payload]);
        } else {
            Log::info("Vapi Webhook Received: {$type}", ['call_id' => $callId, 'local_call_id' => $localCallId]);
        }

        $call = null;
        if ($localCallId) {
            $call = Call::find($localCallId);
        }
        
        if (!$call && $callId) {
            $call = Call::where('call_id', $callId)->first();
        }
        
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

        // Always update call_id if we have it and it's missing locally
        if ($call && $callId && !$call->call_id) {
            $call->update(['call_id' => $callId]);
        }

        switch ($type) {
            case 'assistant.started':
            case 'call-started':
                if ($call) {
                    $call->update(['status' => 'in-progress']);
                    broadcast(new \App\Events\CallProgressUpdated(
                        $call->user_id, 'call_started', 'live', 'in_progress'
                    ));
                }
                break;

            case 'tool-calls':
                $results = $this->handleToolCall($payload, $call);
                return response()->json([
                    'results' => $results
                ]);

            case 'end-of-call-report':
            case 'call-ended':
                if ($call) {
                    $call->update([
                        'status' => 'completed',
                        'duration' => $payload['message']['call']['duration'] ?? 0,
                        'transcript' => $payload['message']['artifact']['transcript'] ?? null,
                        'recording_url' => $payload['message']['artifact']['recordingUrl'] ?? null,
                    ]);

                    $this->processCallTranscript($call);
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
        $results = [];
        
        foreach ($toolCalls as $toolCall) {
            $result = [
                'toolCallId' => $toolCall['id'],
                'result' => 'success'
            ];

            if ($toolCall['function']['name'] === 'report_onboarding_data') {
                $args = $toolCall['function']['arguments'] ?? [];
                $field = $args['field'] ?? null;
                $value = $args['value'] ?? null;

                if ($call && $field && $value) {
                    $metadata = $call->metadata ?? [];
                    $metadata['extracted_fields'][$field] = $value;
                    $call->update(['metadata' => $metadata]);

                    broadcast(new \App\Events\CallProgressUpdated(
                        $call->user_id, $field, $value, 'in_progress'
                    ));
                }
            }

            $results[] = $result;
        }

        return $results;
    }

    protected function processCallTranscript($call)
    {
        $user = $call->user;
        $transcript = $call->transcript;

        Log::info("VapiWebhook: processCallTranscript called for Call {$call->id}", [
            'user_id'         => $user?->id,
            'has_transcript'  => !empty($transcript),
            'transcript_len'  => strlen($transcript ?? ''),
        ]);

        if (!$transcript) {
            Log::warning("VapiWebhook: No transcript for Call {$call->id} — skipping task extraction.");
            return;
        }

        if (!$user) {
            Log::error("VapiWebhook: No user associated with Call {$call->id} — cannot extract tasks.");
            return;
        }

        $prompt = "You are an AI assistant analyzing a call transcript between a user and their daily planner AI.
        Extract any tasks discussed.
        Respond ONLY with a JSON object containing a 'tasks' array.
        Each task object should have:
        - title: (Brief task name)
        - details: (Any specific instructions mentioned)
        - estimated_minutes: (Integer. Estimated duration in minutes. Default to 60 if not specified)
        - status: (pending or completed. Usually pending for new tasks, or completed if they say they already did it)

        Transcript:
        {$transcript}";

        Log::info("VapiWebhook: Sending transcript to OpenRouter for Call {$call->id}");

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openrouter.api_key'),
            'HTTP-Referer'  => config('app.url'),
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model'           => 'deepseek/deepseek-chat',
            'messages'        => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'response_format' => ['type' => 'json_object']
        ]);

        if (!$response->successful()) {
            Log::error("VapiWebhook: OpenRouter request failed for Call {$call->id}", [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return;
        }

        $content = $response->json()['choices'][0]['message']['content'] ?? null;

        Log::info("VapiWebhook: OpenRouter response for Call {$call->id}", [
            'raw_content' => $content,
        ]);

        $extractedData = json_decode($content, true);
        $tasks = $extractedData['tasks'] ?? [];

        Log::info("VapiWebhook: Extracted " . count($tasks) . " task(s) from transcript for Call {$call->id}");

        if (empty($tasks)) {
            Log::warning("VapiWebhook: No tasks found in transcript for Call {$call->id}");
            return;
        }

        DB::transaction(function() use ($user, $tasks, $call) {
            try {
                $userDate = now()->setTimezone($user->timezone)->toDateString();
                foreach ($tasks as $taskData) {
                    $estimatedMins = (int)($taskData['estimated_minutes'] ?? 60);

                    $task = Task::create([
                        'user_id'                 => $user->id,
                        'title'                   => $taskData['title'] ?? 'Extracted Task',
                        'input_text'              => $taskData['details'] ?? '',
                        'priority'                => 'medium',
                        'status'                  => $taskData['status'] ?? 'pending',
                        'date'                    => $userDate,
                        'estimated_minutes'       => $estimatedMins,
                        'scheduled_followup_time' => now()->addMinutes($estimatedMins),
                    ]);

                    Log::info("VapiWebhook: Created task {$task->id} for User {$user->id}", [
                        'title' => $task->title,
                        'date'  => $task->date,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error("VapiWebhook: Failed to save tasks for Call {$call->id}: " . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
            }
        });
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
