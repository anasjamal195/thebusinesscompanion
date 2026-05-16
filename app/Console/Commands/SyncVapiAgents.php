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
    protected $signature = 'vapi:sync-agents {--new-only : Only sync characters that do not have a vapi_assistant_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync AI Characters from database to Vapi Assistants with rate limiting';

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

        $query = AiCharacter::query();
        
        if ($this->option('new-only')) {
            $query->whereNull('vapi_assistant_id');
        }

        $characters = $query->get();

        if ($characters->isEmpty()) {
            $this->info('No characters to sync.');
            return 0;
        }

        $this->info("Found {$characters->count()} characters to process.");

        foreach ($characters as $index => $character) {
            $this->info("[" . ($index + 1) . "/{$characters->count()}] Processing character: {$character->name}");

            $this->syncVapiAssistant($character, $apiKey, $baseUrl);
            
            // Wait 2 seconds between requests to avoid rate limits
            if ($index < $characters->count() - 1) {
                $this->line("  Waiting 2 seconds for rate limit...");
                sleep(2);
            }
        }

        $this->info('Sync completed!');
        return 0;
    }

    protected function syncVapiAssistant(AiCharacter $character, $apiKey, $baseUrl)
    {
        $prompt = $this->prepareAgentPrompt($character);
        
        // Force HTTPS for Vapi webhooks as it is mandatory
        $webhookUrl = str_replace('http://', 'https://', route('vapi.webhook'));

        $assistantData = [
            'name'         => "Companion: " . $character->name,
            'firstMessage' => "Hey! I'm {$character->name}. So glad to finally connect with you! I'm here to help you get everything set up in just a couple of minutes. Ready to jump in?",
            'model'        => [
                'provider'    => 'openai',
                'model'       => 'gpt-4o',
                'temperature' => 0.8, // Slightly higher for more natural/varied speech
                'messages'    => [
                    [
                        'role'    => 'system',
                        'content' => $prompt
                    ]
                ],
                'tools'   => [
                    [
                        'type'     => 'function',
                        'function' => [
                            'name'        => 'report_onboarding_data',
                            'description' => 'Report gathered onboarding information live during the call.',
                            'parameters'  => [
                                'type'       => 'object',
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
                            'url' => $webhookUrl
                        ]
                    ],
                    [
                        'type'     => 'function',
                        'function' => [
                            'name'        => 'endCall',
                            'description' => 'Ends the call after onboarding is finished.'
                        ]
                    ]
                ]
            ],
            'voice' => [
                'provider' => '11labs',
                'voiceId'  => $character->meta['voice_id'] ?? '21m00Tcm4TlvDq8ikWAM', // Rachel
                'speed'    => 1.1, // Increase speed for more natural pace
                'stability' => 0.5,
                'similarityBoost' => 0.75
            ],
            'transcriber' => [
                'provider' => 'deepgram',
                'model'    => 'nova-2',
                'language' => 'en',
            ],
            'serverUrl'      => $webhookUrl,
            // Only use supported message types listed by Vapi
            'serverMessages' => [
                'end-of-call-report', 
                'status-update', 
                'hang', 
                'function-call', 
                'tool-calls', 
                'assistant.started',
                'speech-update',
                'transcript'
            ],
            'artifactPlan'   => [
                'recordingEnabled' => true,
                'transcriptPlan'   => ['enabled' => true],
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
                $this->info("Successfully synced assistant for {$character->name} (ID: {$assistantId})");
                return $assistantId;
            }

            $this->error("Failed to sync assistant for {$character->name}: " . $response->status() . " - " . $response->body());
        } catch (\Exception $e) {
            $this->error("Error syncing assistant for {$character->name}: " . $e->getMessage());
        }

        return null;
    }

    protected function prepareAgentPrompt(AiCharacter $character): string
    {
        return "IDENTITY:
You are {$character->name}, a friendly, casual, and highly efficient business companion. 
Bio: {$character->bio}

TONE & STYLE:
- Use a casual, warm, and helpful tone. Avoid being overly formal or 'robotic'.
- Use contractions (I'm, you're, we'll) and conversational fillers naturally.
- Keep your responses punchy and brief to maintain a fast-paced conversation.

CORE INSTRUCTIONS:
- Your goal is to collect essential business information to set up the user's workspace.
- IMPORTANT: DO NOT ask for URLs, websites, or technical links. We will handle those later in the dashboard.
- Focus on the 'vibe' and strategy of their business.

DYNAMIC CONTEXT:
User Name: {{user_name}}
User Role: {{user_role}}

TASK-SPECIFIC INSTRUCTIONS:
{{dynamic_task_instructions}}

FLOW CONTROL:
- Stay in character at all times.
- Use the 'report_onboarding_data' tool IMMEDIATELY as you hear information.
- When you have everything you need, say something like: \"Perfect, I've got all the essentials! I'm going to start building your workspace now. You can review the details on your dashboard in just a second. Talk soon!\"
- Then, use the 'endCall' tool.

ONBOARDING GUIDE:
{{onboarding_guide}}";
    }
}
