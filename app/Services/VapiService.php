<?php

namespace App\Services;

use App\Models\Call;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VapiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.vapi.ai';

    public function __construct()
    {
        $this->apiKey = config('services.vapi.private_key') ?? '';
        
        if (empty($this->apiKey)) {
            Log::error("VapiService: VAPI_PRIVATE_KEY is missing from configuration.");
        }
    }

    /**
     * Create an outbound call for a user.
     */
    public function createCall(User $user, string $taskType = 'onboarding', array $extraMetadata = [])
    {
        $companion = $user->companion;
        $phoneNumber = $user->profile->phone_number;

        if (!$companion || !$companion->vapi_assistant_id) {
            Log::error("Cannot initiate Vapi call: User {$user->id} companion has no Vapi Assistant ID.");
            return false;
        }

        if (!$phoneNumber) {
            Log::error("Cannot initiate Vapi call: User {$user->id} has no phone number.");
            return false;
        }

        // Prepare dynamic variables/assistant overrides
        $assistantOverrides = $this->prepareAssistantOverrides($user, $taskType);
        
        // Merge with any extra metadata provided
        $assistantOverrides['variableValues'] = array_merge($assistantOverrides['variableValues'] ?? [], $extraMetadata);

        // Clean phone number (ensure it starts with +)
        if (!str_starts_with($phoneNumber, '+')) {
            $phoneNumber = '+' . ltrim($phoneNumber, '0');
        }

        try {
            Log::info("VapiService: Posting to Vapi", [
                'url' => "{$this->baseUrl}/call",
                'phone' => $phoneNumber,
                'assistantId' => $companion->vapi_assistant_id
            ]);

            $response = Http::withToken($this->apiKey)
                ->post("{$this->baseUrl}/call", [
                    'phoneNumberId' => config('services.vapi.phone_number_id'),
                    'assistantId' => $companion->vapi_assistant_id,
                    'customer' => [
                        'number' => $phoneNumber,
                        'name' => $user->name,
                    ],
                    'assistantOverrides' => $assistantOverrides,
                ]);

            if ($response->successful()) {
                $vapiCall = $response->json();
                
                // Persist the call in our database
                Call::create([
                    'call_id' => $vapiCall['id'],
                    'user_id' => $user->id,
                    'ai_character_id' => $companion->id,
                    'status' => 'initiated',
                    'direction' => 'outbound',
                    'metadata' => [
                        'task_type' => $taskType,
                        'variable_values' => $assistantOverrides['variableValues'],
                        'vapi_response' => $vapiCall
                    ],
                ]);

                Log::info("Vapi call initiated for User {$user->id}", ['call_id' => $vapiCall['id']]);
                return $vapiCall;
            }

            Log::error("Vapi API error: " . $response->status() . " - " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("Vapi Exception: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return false;
        }
    }

    /**
     * Prepare overrides and variables for the Vapi Assistant.
     */
    protected function prepareAssistantOverrides(User $user, string $taskType): array
    {
        $companion = $user->companion;
        $systemPrompt = $this->prepareDynamicSystemPrompt($user, $taskType);
        $firstMessage = $this->prepareFirstMessage($user, $taskType);

        return [
            'firstMessage' => $firstMessage,
            'variableValues' => [
                'user_name' => $user->name,
                'user_role' => $user->role ?? 'Founder',
                'full_system_prompt' => $systemPrompt,
                'dynamic_task_instructions' => $this->getTaskInstructions($taskType),
                'onboarding_guide' => $taskType === 'onboarding' ? $this->getOnboardingGuide() : '',
            ],
            'model' => [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt,
                    ]
                ],
                'systemPrompt' => $systemPrompt,
            ],
            'voice' => [
                'speed' => 1.2,
                'stability' => 0.6,
                'style' => 0.15,
            ]
        ];
    }

    /**
     * Get data required for the web call view.
     */
    public function getWebCallData(User $user, string $taskType = 'onboarding'): array
    {
        return [
            'assistantId' => $user->companion->vapi_assistant_id,
            'systemPromptTemplate' => "{{full_system_prompt}}",
            'fullSystemPrompt' => $this->prepareDynamicSystemPrompt($user, $taskType),
            'firstMessage' => $this->prepareFirstMessage($user, $taskType),
        ];
    }

    public function prepareDynamicSystemPrompt(User $user, string $taskType): string
    {
        $companion = $user->companion;
        $basePrompt = $companion->system_prompt ?: "You are a professional business assistant.";
        
        $prompt = "TONE & STYLE:
- BE EXTREMELY HUMAN. Never say 'As an AI' or 'I am a model'.
- Use a casual, friendly, and energetic tone.
- Use natural filler words (like 'um', 'uh', 'gotcha', 'totally', 'cool') naturally.
- Keep your sentences short and punchy.
- React naturally to what the user says.
- Treat the user like a friend you're helping out.

IDENTITY:
You are {$companion->name}.
Bio: {$companion->bio}

CORE PERSONALITY:
{$basePrompt}

TASK-SPECIFIC INSTRUCTIONS:
" . $this->getTaskInstructions($taskType) . "

FLOW CONTROL:
- Stay in character at all times.
- Keep responses concise.
- IMPORTANT: If this is onboarding, when you have all the business info, mention that the user can fill in specific URLs later on the dashboard.
- When finished, say a warm goodbye and use the 'endCall' tool immediately.

ONBOARDING GUIDE:
" . ($taskType === 'onboarding' ? $this->getOnboardingGuide() : "N/A") . "

USER CONTEXT:
User Name: {$user->name}
User Role: " . ($user->role ?? 'Founder');

        return $prompt;
    }

    public function prepareFirstMessage(User $user, string $taskType): string
    {
        $companion = $user->companion;
        
        if ($taskType === 'onboarding') {
            return "Hey {$user->name}! I'm {$companion->name}, your new business companion. I'm so excited to help you get this workspace set up. Ready to dive in?";
        }

        return "Hey {$user->name}, it's {$companion->name}. Hope you're having a great day! How can I help you right now?";
    }

    protected function getTaskInstructions(string $taskType): string
    {
        return match ($taskType) {
            'onboarding' => "Hey! Welcome the user and get some quick details about their business, what they're working on, and their first big task. " .
                            "Mention that they can skip the URLs for now—they can add those on the dashboard later. " .
                            "Once you've got the gist of it, use the 'endCall' tool to wrap things up.",
            'follow_up' => "Catch up with the user on their tasks. See if they've got any blockers.",
            default => "Help the user out with whatever business needs they've got.",
        };
    }

    protected function getOnboardingGuide(): string
    {
        return "STUFF TO CHAT ABOUT:
        1. Business Type (SaaS, Agency, etc.)
        2. Industry
        3. Who are they targeting?
        4. Experience level
        5. First Project Name
        6. What's the project about? (Description)
        7. First Task to get started on
        8. Should we call them after tasks are done?
        
        VIBE CHECK:
        - Keep it light and friendly.
        - One question at a time, don't grill them.
        - Skip any URL requests—tell them the dashboard will handle that.
        - Use 'report_onboarding_data' as soon as they give you an answer.
        - Wrap up with 'endCall' when done.";
    }
}
