<?php

namespace App\Services;

use App\Models\Call;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RetellService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.retellai.com';

    public function __construct()
    {
        $this->apiKey = config('services.retell.api_key');
    }

    /**
     * Create an outbound call for a user.
     */
    public function createCall(User $user, string $taskType = 'onboarding', array $extraMetadata = [])
    {
        $companion = $user->companion;
        $phoneNumber = $user->profile->phone_number;

        if (!$companion || !$companion->retell_agent_id) {
            Log::error("Cannot initiate Retell call: User {$user->id} companion has no Retell Agent ID.");
            return false;
        }

        if (!$phoneNumber) {
            Log::error("Cannot initiate Retell call: User {$user->id} has no phone number.");
            return false;
        }

        // Prepare dynamic variables loosely coupled with the agent prompt
        $dynamicVariables = $this->prepareDynamicVariables($user, $taskType);
        
        // Merge with any extra metadata provided
        $dynamicVariables = array_merge($dynamicVariables, $extraMetadata);

        try {
            $response = Http::withToken($this->apiKey)
                ->post("{$this->baseUrl}/create-phone-call", [
                    'from_number' => config('services.retell.from_number'),
                    'to_number' => $phoneNumber,
                    'override_agent_id' => $companion->retell_agent_id,
                    'retell_llm_dynamic_variables' => $dynamicVariables,
                ]);

            if ($response->successful()) {
                $retellCall = $response->json();
                
                // Persist the call in our database
                Call::create([
                    'call_id' => $retellCall['call_id'],
                    'user_id' => $user->id,
                    'ai_character_id' => $companion->id,
                    'status' => 'initiated',
                    'direction' => 'outbound',
                    'metadata' => array_merge($dynamicVariables, [
                        'task_type' => $taskType,
                        'retell_response' => $retellCall
                    ]),
                ]);

                Log::info("Retell call initiated for User {$user->id}", ['call_id' => $retellCall['call_id']]);
                return $retellCall;
            }

            Log::error("Retell API error: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("Retell Exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Prepare variables that match the placeholders in the Retell Agent prompt.
     */
    protected function prepareDynamicVariables(User $user, string $taskType): array
    {
        $variables = [
            'user_name' => $user->name,
            'user_role' => $user->role ?? 'Founder',
            'dynamic_task_instructions' => $this->getTaskInstructions($taskType),
        ];

        if ($taskType === 'onboarding') {
            $variables['onboarding_guide'] = $this->getOnboardingGuide();
        }

        return $variables;
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
