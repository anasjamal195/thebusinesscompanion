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
                    'metadata' => array_merge($assistantOverrides['variableValues'], [
                        'task_type' => $taskType,
                        'vapi_response' => $vapiCall
                    ]),
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
        return [
            'variableValues' => [
                'user_name' => $user->name,
                'user_role' => $user->role ?? 'Founder',
                'dynamic_task_instructions' => $this->getTaskInstructions($taskType),
                'onboarding_guide' => $taskType === 'onboarding' ? $this->getOnboardingGuide() : '',
            ]
        ];
    }

    protected function getTaskInstructions(string $taskType): string
    {
        return match ($taskType) {
            'onboarding' => "Your primary task is to onboard the user. Welcome them and collect their business details and initial project goals as per the guide.",
            'follow_up' => "Follow up on the pending tasks we discussed. Ask if they need any help with the current project blockages.",
            default => "Have a natural conversation and assist the user with their business needs.",
        };
    }

    protected function getOnboardingGuide(): string
    {
        return "GOAL: Collect information for two sections:
        1. Business Details: Business Type, Industry, Target Audience, and Experience Level.
        2. Initial Project: Project Name, URL (optional), Description, Success Metric, Current Problems, and Urgent Tasks.
        
        FLOW:
        - Introduce yourself warmly.
        - Ask questions one by one.
        - Confirm you've received everything.
        - End with: \"I'll get to you once this is done\".";
    }
}
