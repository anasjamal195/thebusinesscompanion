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
                // Log the full payload for debugging
                Log::info("VapiWebhook: {$type} received", [
                    'call_id'     => $callId,
                    'has_artifact'=> isset($payload['message']['artifact']),
                    'artifact_keys' => array_keys($payload['message']['artifact'] ?? []),
                    'has_transcript' => !empty($payload['message']['artifact']['transcript']),
                    'duration'    => $payload['message']['call']['duration'] ?? $payload['message']['durationSeconds'] ?? null,
                ]);

                if ($call) {
                    // Handle both end-of-call-report (artifact is inside message) and call-ended
                    $artifact = $payload['message']['artifact'] ?? [];
                    $transcript = $artifact['transcript'] ?? null;
                    $recordingUrl = $artifact['recordingUrl'] ?? null;
                    $duration = $payload['message']['call']['duration']
                        ?? $payload['message']['durationSeconds']
                        ?? 0;

                    $call->update([
                        'status'        => 'completed',
                        'duration'      => $duration,
                        'transcript'    => $transcript,
                        'recording_url' => $recordingUrl,
                    ]);

                    // Only process transcript for morning/followup call types
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

            $args = $toolCall['function']['arguments'] ?? [];

            if ($toolCall['function']['name'] === 'report_onboarding_data') {
                $field = $args['field'] ?? null;
                $value = $args['value'] ?? null;

                if ($call && $field && $value) {
                    $metadata = $call->metadata ?? [];
                    $metadata['extracted_fields'][$field] = $value;
                    $call->update(['metadata' => $metadata]);

                    // If field is 'task_completed', mark the task as done
                    if ($field === 'task_completed' && $call->user_id) {
                        Task::where('user_id', $call->user_id)
                            ->where('title', $value)
                            ->where('status', 'pending')
                            ->whereDate('date', now()->setTimezone(
                                optional($call->user)->timezone ?? 'UTC'
                            )->toDateString())
                            ->update(['status' => 'completed']);
                    }

                    // If field is 'reschedule_followup', update the task's follow-up time
                    // value format: "{taskId}:{minutes}" e.g. "4:30"
                    if ($field === 'reschedule_followup' && $call->user_id && str_contains($value, ':')) {
                        $parts = explode(':', $value, 2);
                        $taskId = (int) trim($parts[0]);
                        $minutes = (int) trim($parts[1]);
                        if ($taskId && $minutes > 0) {
                            Task::where('id', $taskId)
                                ->where('user_id', $call->user_id)
                                ->update(['scheduled_followup_time' => now()->addMinutes($minutes)]);
                        }
                    }

                    broadcast(new \App\Events\CallProgressUpdated(
                        $call->user_id, $field, $value, 'in_progress'
                    ));
                }
            }

            if ($toolCall['function']['name'] === 'carry_forward_tasks') {
                if ($call && $call->user_id) {
                    $userDate = now()->setTimezone(
                        optional($call->user)->timezone ?? 'UTC'
                    )->toDateString();
                    $tomorrowDate = now()->setTimezone(
                        optional($call->user)->timezone ?? 'UTC'
                    )->addDay()->toDateString();

                    $taskIds = $args['task_ids'] ?? [];
                    if (empty($taskIds)) {
                        // Carry forward all pending tasks for today
                        Task::where('user_id', $call->user_id)
                            ->whereDate('date', $userDate)
                            ->where('status', 'pending')
                            ->update(['date' => $tomorrowDate]);
                    } else {
                        Task::whereIn('id', $taskIds)
                            ->where('user_id', $call->user_id)
                            ->update(['date' => $tomorrowDate]);
                    }
                }
            }

            if ($toolCall['function']['name'] === 'discard_tasks') {
                if ($call && $call->user_id) {
                    $taskIds = $args['task_ids'] ?? [];
                    if (empty($taskIds)) {
                        // Mark all today's pending tasks as discarded
                        Task::where('user_id', $call->user_id)
                            ->whereDate('date', now()->setTimezone(
                                optional($call->user)->timezone ?? 'UTC'
                            )->toDateString())
                            ->where('status', 'pending')
                            ->update(['status' => 'discarded']);
                    } else {
                        Task::whereIn('id', $taskIds)
                            ->where('user_id', $call->user_id)
                            ->update(['status' => 'discarded']);
                    }
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

        // Fetch existing pending tasks for the user today to help the AI match them
        $todayStr = now()->setTimezone($user->timezone)->toDateString();
        $existingTasks = Task::where('user_id', $user->id)
            ->whereDate('date', $todayStr)
            ->get(['id', 'title', 'status']);

        $existingContext = '';
        if ($existingTasks->isNotEmpty()) {
            $existingLines = $existingTasks->map(fn ($t) => "- Task #{$t->id}: \"{$t->title}\" (status: {$t->status})")->implode("\n");
            $existingContext = "\n\nEXISTING TASKS FOR TODAY:\n{$existingLines}";
        }

        $prompt = "You are an AI assistant analyzing a call transcript between a user and their daily planner AI.
        Your job is to identify what changed with the user's tasks during this call.
        Respond ONLY with a JSON object containing these optional arrays:

        'completed_tasks' — tasks the user said they FINISHED. Each object: {title, existing_task_id}
        'updated_tasks' — tasks where the user gave new details, time estimates, or priority. Each object: {title, existing_task_id, details, estimated_minutes, priority}
        'new_tasks' — brand new tasks the user wants to add. Each object: {title, details, estimated_minutes, priority}
        {$existingContext}

        IMPORTANT:
        - If a task already exists (listed above), INCLUDE its existing_task_id so we UPDATE it instead of creating a duplicate.
        - Use existing_task_id whenever you can match a task from the transcript to an existing task by title.
        - Only put tasks in 'new_tasks' if they are TRULY new — not mentioned in existing tasks at all.

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
        $completedTasks = $extractedData['completed_tasks'] ?? [];
        $updatedTasks = $extractedData['updated_tasks'] ?? [];
        $newTasks = $extractedData['new_tasks'] ?? [];

        Log::info("VapiWebhook: Extracted data for Call {$call->id}", [
            'completed' => count($completedTasks),
            'updated'   => count($updatedTasks),
            'new'       => count($newTasks),
        ]);

        if (empty($completedTasks) && empty($updatedTasks) && empty($newTasks)) {
            Log::warning("VapiWebhook: No task changes found in transcript for Call {$call->id}");
            return;
        }

        DB::transaction(function() use ($user, $completedTasks, $updatedTasks, $newTasks) {
            try {
                $userDate = now()->setTimezone($user->timezone)->toDateString();

                // ── Mark completed tasks ──
                foreach ($completedTasks as $taskData) {
                    $query = Task::where('user_id', $user->id)->whereDate('date', $userDate);

                    if (!empty($taskData['existing_task_id'])) {
                        $query->where('id', $taskData['existing_task_id']);
                    } else {
                        $query->where('title', $taskData['title'] ?? '');
                    }

                    $matched = $query->where('status', 'pending')->first();
                    if ($matched) {
                        $matched->update(['status' => 'completed']);
                        Log::info("VapiWebhook: Completed task {$matched->id} for User {$user->id}", ['title' => $matched->title]);
                    }
                }

                // ── Update existing tasks ──
                foreach ($updatedTasks as $taskData) {
                    $query = Task::where('user_id', $user->id)->whereDate('date', $userDate);

                    if (!empty($taskData['existing_task_id'])) {
                        $query->where('id', $taskData['existing_task_id']);
                    } else {
                        $query->where('title', $taskData['title'] ?? '');
                    }

                    $matched = $query->first();
                    if ($matched) {
                        $update = [];
                        if (isset($taskData['details'])) $update['input_text'] = $taskData['details'];
                        if (isset($taskData['estimated_minutes'])) {
                            $update['estimated_minutes'] = (int) $taskData['estimated_minutes'];
                            $update['scheduled_followup_time'] = now()->addMinutes((int) $taskData['estimated_minutes']);
                        }
                        if (isset($taskData['priority'])) {
                            $p = $taskData['priority'];
                            $update['priority'] = in_array($p, ['high','medium','low']) ? $p : 'medium';
                        }
                        if (!empty($update)) {
                            $matched->update($update);
                            Log::info("VapiWebhook: Updated task {$matched->id} for User {$user->id}", $update);
                        }
                    }
                }

                // ── Create new tasks ──
                foreach ($newTasks as $taskData) {
                    $estimatedMins = (int)($taskData['estimated_minutes'] ?? 60);
                    $priority = $taskData['priority'] ?? 'medium';
                    if (!in_array($priority, ['high','medium','low'])) $priority = 'medium';

                    $task = Task::create([
                        'user_id'                 => $user->id,
                        'title'                   => $taskData['title'] ?? 'Extracted Task',
                        'input_text'              => $taskData['details'] ?? '',
                        'priority'                => $priority,
                        'status'                  => 'pending',
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
                Log::error("VapiWebhook: Failed to process tasks: " . $e->getMessage(), [
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
