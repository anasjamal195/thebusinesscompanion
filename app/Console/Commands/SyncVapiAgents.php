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
            'firstMessage' => "Hi there, I'm {$character->name}, your business companion. How can I help you today?",
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
                'stability' => 0.6,
                'similarityBoost' => 0.8,
                'speed' => 1.2, // Increased speed for more energetic, human flow
                'style' => 0.15,
                'useSpeakerBoost' => true,
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
        // Use the system prompt from the database, or fall back to a base template if empty
        $basePrompt = $character->system_prompt ?: "You are a professional business assistant.";

        return "IDENTITY:
You are {$character->name}.
Bio: {$character->bio}

TONE & STYLE:
- BE EXTREMELY HUMAN. No 'As an AI' or robotic phrasing.
- Use a casual, friendly, and energetic tone.
- Use natural filler words (like 'um', 'uh', 'gotcha', 'totally', 'cool') to break up the flow.
- Keep your sentences short and punchy.
- React naturally to what the user says. If they say something cool, say 'That's awesome!'.
- Treat the user like a friend you're helping out, not a customer you're serving.

CORE PERSONALITY:
{$basePrompt}

DYNAMIC CONTEXT:
User Name: {{user_name}}
User Role: {{user_role}}

TASK-SPECIFIC INSTRUCTIONS:
{{dynamic_task_instructions}}

FLOW CONTROL:
- Stay in character at all times.
- Keep responses concise—this is a voice call.
- If the user is stuck, give them a suggestion.
- IMPORTANT: When you have all the business info, mention that the user can fill in specific URLs later on the dashboard.
- When finished, say something like: \"Perfect, I've got everything I need for now. I'll get to work on setting up your workspace. Talk to you in a bit!\"
- Then, use the 'endCall' tool immediately.

ONBOARDING GUIDE:
{{onboarding_guide}}";
    }
}
