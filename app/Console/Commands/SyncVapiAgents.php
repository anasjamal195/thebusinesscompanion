<?php

namespace App\Console\Commands;

use App\Models\AiCharacter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncVapiAgents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vapi:sync-agents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync AI Characters from database to Vapi Assistants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = config('services.vapi.private_key');
        $baseUrl = 'https://api.vapi.ai';

        if (!$apiKey) {
            $this->error('VAPI_PRIVATE_KEY is not configured in services.php');
            return 1;
        }

        $characters = AiCharacter::all();

        foreach ($characters as $character) {
            $this->info("Processing character: {$character->name}");

            $this->syncVapiAssistant($character, $apiKey, $baseUrl);
        }

        $this->info('Sync completed!');
        return 0;
    }

    protected function syncVapiAssistant(AiCharacter $character, $apiKey, $baseUrl)
    {
        $prompt = $this->prepareAgentPrompt($character);
        
        $assistantData = [
            'name' => "Companion: " . $character->name,
            'firstMessage' => "Hi there, I'm {$character->name}. How can I help you today?",
            'model' => [
                'provider' => 'openai',
                'model' => 'gpt-4o',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $prompt
                    ]
                ]
            ],
            'voice' => [
                'provider' => '11labs',
                'voiceId' => $character->meta['voice_id'] ?? '21m00Tcm4TlvDq8ikWAM', // Rachel
            ],
            'transcriber' => [
                'provider' => 'deepgram',
                'model' => 'nova-2',
                'language' => 'en',
            ],
            'serverUrl' => route('vapi.webhook'),
            'artifactPlan' => [
                'videoRecordingEnabled' => true,
            ]
        ];

        try {
            if ($character->vapi_assistant_id) {
                $this->line("Updating existing Vapi Assistant: {$character->vapi_assistant_id}");
                $response = Http::withToken($apiKey)
                    ->patch("{$baseUrl}/assistant/{$character->vapi_assistant_id}", $assistantData);
            } else {
                $this->line("Creating new Vapi Assistant...");
                $response = Http::withToken($apiKey)
                    ->post("{$baseUrl}/assistant", $assistantData);
            }

            if ($response->successful()) {
                $assistantId = $response->json('id');
                if (!$character->vapi_assistant_id) {
                    $character->update(['vapi_assistant_id' => $assistantId]);
                }
                $this->info("Successfully synced assistant for {$character->name}");
                return $assistantId;
            }

            $this->error("Failed to sync assistant for {$character->name}: " . $response->body());
        } catch (\Exception $e) {
            $this->error("Error syncing assistant for {$character->name}: " . $e->getMessage());
        }

        return null;
    }

    protected function prepareAgentPrompt(AiCharacter $character): string
    {
        return "IDENTITY:
You are {$character->name}.
Bio: {$character->bio}

CORE INSTRUCTIONS:
{$character->system_prompt}

DYNAMIC CONTEXT (Passed via API):
User Name: {{user_name}}
User Role: {{user_role}}

TASK-SPECIFIC INSTRUCTIONS:
{{dynamic_task_instructions}}

FLOW CONTROL:
- Stay in character at all times.
- Keep responses concise and human-like.
- When you have completed the task or collected the necessary information, you MUST end the call with the exact phrase: \"I'll get to you once this is done\"

If this is an onboarding call, use the following guide:
{{onboarding_guide}}";
    }
}
