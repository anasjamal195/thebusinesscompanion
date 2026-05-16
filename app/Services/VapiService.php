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
        return [
            'variableValues' => [
                'user_name' => $user->name,
                'user_role' => $user->role ?? 'Founder',
                'dynamic_task_instructions' => $this->getTaskInstructions($taskType),
                'onboarding_guide' => $taskType === 'onboarding' ? $this->getOnboardingGuide() : '',
            ],
        ];
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
