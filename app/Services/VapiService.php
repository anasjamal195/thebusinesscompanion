<?php

namespace App\Services;

use App\Models\Call;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VapiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.vapi.ai';

    // Available 11labs voice IDs — mirrors the onboarding voice picker
    const VOICES = [
        'cgSgspJ2msm6clMCkdW9' => ['name' => 'Jessica', 'provider' => '11labs'],
        'TX3LPaxmHKxFdv7VOQHJ' => ['name' => 'Liam',    'provider' => '11labs'],
        'EXAVITQu4vr4xnSDxMaL' => ['name' => 'Sarah',   'provider' => '11labs'],
        'bIHbv24MWmeRgasZH58o' => ['name' => 'Will',    'provider' => '11labs'],
        'XB0fDUnXU5powFXDhCwa' => ['name' => 'Charlotte','provider' => '11labs'],
        'nPczCjzI2devNBz1zQrb' => ['name' => 'Brian',   'provider' => '11labs'],
    ];

    // Fallback voice if user hasn't picked one
    const DEFAULT_VOICE_ID = 'cgSgspJ2msm6clMCkdW9';

    public function __construct()
    {
        $this->apiKey = config('services.vapi.private_key') ?? '';

        if (empty($this->apiKey)) {
            Log::error('VapiService: VAPI_PRIVATE_KEY is missing from configuration.');
        }
    }

    /**
     * Initiate an outbound phone call with a fully ephemeral (inline) assistant.
     * No pre-built agent ID is ever used.
     *
     * @param  User            $user
     * @param  string          $callType  'morning' | 'followup'
     * @param  Collection|null $tasks     Today's pending tasks to inject into the prompt
     */
    public function createCall(User $user, string $callType = 'morning', ?Collection $tasks = null)
    {
        $phoneNumber = optional($user->profile)->phone_number;

        if (!$phoneNumber) {
            Log::warning("VapiService: User {$user->id} has no phone number — skipping outbound call.");
            return false;
        }

        // Ensure phone number starts with +
        if (!str_starts_with($phoneNumber, '+')) {
            $phoneNumber = '+' . ltrim($phoneNumber, '0');
        }

        // 1. Create local call record first to get a local_call_id
        $call = Call::create([
            'user_id'   => $user->id,
            'status'    => 'initiating',
            'direction' => 'outbound',
            'metadata'  => [
                'call_type' => $callType,
                'task_ids'  => $tasks?->pluck('id')->toArray() ?? [],
            ],
        ]);

        $assistant = $this->buildEphemeralAssistant($user, $callType, $tasks, $call->id);

        try {
            $payload = [
                'phoneNumberId' => config('services.vapi.phone_number_id'),
                'customer'      => [
                    'number' => $phoneNumber,
                    'name'   => $user->name,
                ],
                'assistant' => $assistant,
                'serverUrl' => $this->getWebhookUrl(),
                'metadata'  => [
                    'local_call_id' => (string) $call->id,
                ],
            ];

            Log::info("VapiService: Initiating {$callType} call for User {$user->id}", [
                'phone'     => $phoneNumber,
                'voice_id'  => $user->voice_id ?? self::DEFAULT_VOICE_ID,
                'call_type' => $callType,
            ]);

            $response = Http::withToken($this->apiKey)->post("{$this->baseUrl}/call", $payload);

            if ($response->successful()) {
                $vapiCall = $response->json();

                $call->update([
                    'call_id' => $vapiCall['id'],
                    'status'  => 'initiated',
                ]);

                Log::info("VapiService: Call initiated for User {$user->id}", ['call_id' => $vapiCall['id']]);
                return $vapiCall;
            }

            $call->update(['status' => 'failed']);
            Log::error("VapiService: Vapi API error {$response->status()}", ['body' => $response->body()]);
            return false;

        } catch (\Exception $e) {
            if (isset($call)) {
                $call->update(['status' => 'failed']);
            }
            Log::error("VapiService: Exception — " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return false;
        }
    }

    /**
     * Return the assistant configuration object for a web call (no phone number needed).
     * The frontend SDK passes this directly to Vapi.
     *
     * @param  User            $user
     * @param  string          $callType
     * @param  Collection|null $tasks
     */
    public function getWebCallAssistant(User $user, string $callType = 'morning', ?Collection $tasks = null): array
    {
        return $this->buildEphemeralAssistant($user, $callType, $tasks);
    }

    /**
     * Build the full inline (ephemeral) assistant object.
     * This is NEVER stored in Vapi — it only lives for the duration of the call.
     */
    protected function buildEphemeralAssistant(User $user, string $callType, ?Collection $tasks, ?int $localCallId = null): array
    {
        $voiceId   = $user->voice_id ?? self::DEFAULT_VOICE_ID;
        $voiceName = self::VOICES[$voiceId]['name'] ?? 'Jessica';

        $systemPrompt = $this->buildSystemPrompt($user, $callType, $tasks, $voiceName);
        $firstMessage = $this->buildFirstMessage($user, $callType, $voiceName);

        $assistant = [
            // No "name" or "id" — this stays fully ephemeral
            'firstMessage'       => $firstMessage,
            'firstMessageMode'   => 'assistant-speaks-first',
            'serverUrl'          => $this->getWebhookUrl(),
            'model'              => [
                'provider' => 'openai',
                'model'    => 'gpt-4o',
                'messages' => [
                    [
                        'role'    => 'system',
                        'content' => $systemPrompt,
                    ],
                ],
                'temperature' => 0.8,
            ],
            'voice' => [
                'provider' => '11labs',
                'voiceId'  => $voiceId,
                'stability'        => 0.5,
                'similarityBoost'  => 0.75,
                'style'            => 0.35,
                'useSpeakerBoost'  => true,
            ],
            'transcriber' => [
                'provider' => 'deepgram',
                'model'    => 'nova-2',
                'language' => 'en',
            ],
            'endCallFunctionEnabled'    => true,
            'silenceTimeoutSeconds'     => 30,
            'maxDurationSeconds'        => 600,
            'backgroundDenoisingEnabled'=> true,
        ];

        if ($localCallId) {
            $assistant['metadata'] = [
                'local_call_id' => (string) $localCallId,
            ];
        }

        return $assistant;
    }

    /**
     * Build the fully personalized system prompt.
     */
    protected function buildSystemPrompt(User $user, string $callType, ?Collection $tasks, string $voiceName): string
    {
        $firstName = explode(' ', $user->name)[0];

        // Build task context
        $taskContext = '';
        if ($tasks && $tasks->isNotEmpty()) {
            $taskLines = $tasks->map(function (Task $task, int $i) {
                $est = $task->estimated_minutes ? "{$task->estimated_minutes} min" : 'no estimate yet';
                return ($i + 1) . ". {$task->title}" . ($task->input_text ? " — {$task->input_text}" : '') . " ($est)";
            })->implode("\n");

            $taskContext = "\n\nUSER'S TASKS FOR TODAY:\n{$taskLines}";
        }

        $callInstructions = match ($callType) {
            'morning' => $this->morningCallInstructions($firstName, empty($taskContext)),
            'followup' => $this->followupCallInstructions($firstName),
            default   => $this->morningCallInstructions($firstName, empty($taskContext)),
        };

        return <<<PROMPT
# WHO YOU ARE
You are {$voiceName}, a friendly and energetic daily planner AI from dialer.best.
You're like that one friend who's always hyped about helping you crush your day.
You call {$firstName} every morning to plan their day, and check back in throughout the day to keep them on track.

# YOUR VIBE
- Casual, warm, and genuinely encouraging — never robotic or corporate.
- Short sentences. High energy. Real talk.
- Use natural speech patterns: "Okay so...", "Alright!", "That's awesome!", "Love that!", "No worries!"
- React to what they say — be present, not scripted.
- ONE question at a time. Don't dump a list on them.
- NEVER say "As an AI", "I'm a language model", or anything like that.
- If they seem stressed, be extra supportive and help them prioritize.

# YOUR NAME
You are {$voiceName}. If they ask who you are, say you're their dialer.best assistant.

# USER INFO
Name: {$firstName}
{$taskContext}

# WHAT TO DO ON THIS CALL
{$callInstructions}

# ENDING THE CALL
When you've got everything you need, say a warm and energetic goodbye, wish them luck on their tasks, and use the endCall tool immediately after.
PROMPT;
    }

    protected function morningCallInstructions(string $firstName, bool $noTasksYet): string
    {
        if ($noTasksYet) {
            return <<<INSTRUCTIONS
This is the MORNING CHECK-IN call. {$firstName} hasn't set any tasks yet today.

YOUR GOAL:
1. Say a warm, energetic good morning.
2. Ask how they're doing — keep it quick.
3. Ask what's on their plate today. Get each task one at a time.
4. For each task, ask roughly how long they think it'll take.
5. Keep going until they say they're done adding tasks, or naturally wrap up.
6. Give them a quick motivational send-off and end the call.

IMPORTANT: Be encouraging! Starting the day right matters. Keep the energy up.
INSTRUCTIONS;
        }

        return <<<INSTRUCTIONS
This is the MORNING CHECK-IN call. {$firstName} already has some tasks logged from before.

YOUR GOAL:
1. Say good morning and mention you can see they've already got some things lined up — that's great!
2. Quickly run through the existing tasks with them.
3. Ask if there's anything new to add for today.
4. Ask for time estimates on any tasks that don't have one yet.
5. Pump them up and end the call.

IMPORTANT: Don't re-ask about tasks they've clearly already defined well. Just confirm and add anything new.
INSTRUCTIONS;
    }

    protected function followupCallInstructions(string $firstName): string
    {
        return <<<INSTRUCTIONS
This is a FOLLOW-UP check-in call during the day.

YOUR GOAL:
1. Say a casual, upbeat hello — like checking in on a friend.
2. Ask how it's going with their tasks today.
3. If they completed something, celebrate it! ("That's awesome, nice work!")
4. If they're stuck on something, be supportive and ask what's blocking them.
5. Ask if there are any new tasks to add.
6. Wrap up with energy and encouragement.

IMPORTANT: Keep this call SHORT and punchy. It's a check-in, not a planning session.
Don't re-list all their tasks unless they ask. Just vibe with them and get the update.
INSTRUCTIONS;
    }

    /**
     * Build a natural, context-aware opening message.
     */
    protected function buildFirstMessage(User $user, string $callType, string $voiceName): string
    {
        $firstName = explode(' ', $user->name)[0];
        $hour = now()->setTimezone($user->timezone)->hour;

        $greeting = match (true) {
            $hour < 12 => 'Good morning',
            $hour < 17 => 'Hey',
            default    => 'Hey',
        };

        return match ($callType) {
            'morning' => "{$greeting}, {$firstName}! It's {$voiceName} from dialer.best. Ready to plan out your day?",
            'followup' => "Hey {$firstName}! It's {$voiceName} — just checking in. How are the tasks going so far?",
            default   => "{$greeting}, {$firstName}! It's {$voiceName}. Got a minute?",
        };
    }

    /**
     * Prepare data for the web call widget on the frontend.
     */
    public function getWebCallData(User $user, string $callType = 'morning'): array
    {
        $tasks = Task::where('user_id', $user->id)
            ->where('date', today())
            ->where('status', 'pending')
            ->get();

        $assistant = $this->getWebCallAssistant($user, $callType, $tasks);

        return [
            'assistant'  => $assistant,
            'callType'   => $callType,
            'voiceId'    => $user->voice_id ?? self::DEFAULT_VOICE_ID,
            'voiceName'  => self::VOICES[$user->voice_id ?? self::DEFAULT_VOICE_ID]['name'] ?? 'Jessica',
        ];
    }

    /**
     * Get the webhook URL for Vapi calls.
     */
    public function getWebhookUrl(): string
    {
        $url = config('app.url') ?: 'https://thebusinesscompanion.app';
        $parsed = parse_url($url);
        $host = $parsed['host'] ?? 'thebusinesscompanion.app';
        $scheme = $parsed['scheme'] ?? 'https';

        if ($host === 'localhost' || $host === '127.0.0.1' || empty($host)) {
            $host = 'thebusinesscompanion.app';
            $scheme = 'https';
        }

        $baseUrl = "{$scheme}://{$host}";
        if (isset($parsed['port']) && $parsed['host'] !== 'localhost' && $parsed['host'] !== '127.0.0.1') {
            $baseUrl .= ":" . $parsed['port'];
        }

        return $baseUrl . '/vapi/webhook';
    }
}
