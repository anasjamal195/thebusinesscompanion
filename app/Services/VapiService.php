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
        $this->apiKey = config('services.vapi.private_key');
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

        try {
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

            Log::error("Vapi API error: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("Vapi Exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Prepare overrides and variables for the Vapi Assistant.
     */
    protected function prepareAssistantOverrides(User $user, string $taskType): array
    {
        $companion = $user->companion;
        $characterName = $companion->name ?? 'Assistant';
        $characterOccupation = $companion->occupation ?? 'Business Expert';

        return [
            'variableValues' => [
                'user_name' => $user->name,
                'user_role' => $user->role ?? 'Founder',
                'dynamic_task_instructions' => $this->getTaskInstructions($taskType),
                'onboarding_guide' => $taskType === 'onboarding' ? $this->getOnboardingGuide() : '',
            ],
            'model' => [
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are {$characterName}, an expert {$characterOccupation} and business companion. Your goal is to help the user onboard while maintaining your professional identity. " . 
                                     "Use the 'report_onboarding_data' tool as soon as you collect any of the required information. " .
                                     "DO NOT wait until the end of the call to report data. Report it as you get it."
                    ]
                ]
            ],
            'tools' => [
                [
                    'type' => 'function',
                    'function' => [
                        'name' => 'report_onboarding_data',
                        'description' => 'Report gathered onboarding information live during the call.',
                        'parameters' => [
                            'type' => 'object',
                            'properties' => [
                                'field' => [
                                    'type' => 'string',
                                    'enum' => ['business_type', 'industry', 'target_audience', 'experience_level', 'project_name', 'project_description', 'first_task', 'call_followup_preference']
                                ],
                                'value' => ['type' => 'string']
                            ],
                            'required' => ['field', 'value']
                        ]
                    ],
                    'server' => [
                        'url' => route('vapi.webhook') // Ensure this route exists and is accessible
                    ]
                ],
                [
                    'type' => 'function',
                    'function' => [
                        'name' => 'endCall',
                        'description' => 'Ends the call after onboarding is finished.'
                    ]
                ]
            ]
        ];
    }

    protected function getTaskInstructions(string $taskType): string
    {
        return match ($taskType) {
            'onboarding' => "Welcome the user and collect their business details, first project name, and first task. " .
                            "Finally, ask if they want to receive updates via call after task completion. " .
                            "Once finished, use the 'endCall' tool to terminate the call.",
            'follow_up' => "Follow up on the pending tasks. Ask if they need help.",
            default => "Assist the user with their business needs.",
        };
    }

    protected function getOnboardingGuide(): string
    {
        return "REQUIRED FIELDS TO COLLECT:
        1. Business Type (e.g. SaaS, E-commerce, Agency)
        2. Industry
        3. Target Audience
        4. Experience Level
        5. First Project Name
        6. First Project Description
        7. First Task to execute
        8. Call Follow-up Preference (Yes/No for receiving calls after task completion)
        
        INSTRUCTIONS:
        - Be warm and professional.
        - Ask questions one by one.
        - USE THE 'report_onboarding_data' tool immediately after the user provides an answer for any field.
        - After all data is collected, use the 'endCall' tool to end the call.";
    }
}
