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
    protected $signature = 'vapi:sync-agents 
                            {--new-only : Only sync characters that do not have a vapi_assistant_id}
                            {--clean : Delete all existing Vapi assistants for these characters and recreate them}';

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

        if ($this->option('clean')) {
            if (!$this->confirm('This will delete assistants from Vapi and recreate them. Continue?')) {
                return 0;
            }
        }

        $this->info("Found {$characters->count()} characters to process.");

        foreach ($characters as $index => $character) {
            $this->info("[" . ($index + 1) . "/{$characters->count()}] Processing character: {$character->name}");

            if ($this->option('clean') && $character->vapi_assistant_id) {
                $this->deleteVapiAssistant($character, $apiKey, $baseUrl);
            }

            $this->syncVapiAssistant($character, $apiKey, $baseUrl);
            
            // Wait 5 seconds between requests to avoid rate limits
            if ($index < $characters->count() - 1) {
                $this->line("  Waiting 5 seconds for rate limit...");
                sleep(5);
            }
        }

        $this->info('Sync completed!');
        return 0;
    }

    protected function deleteVapiAssistant(AiCharacter $character, $apiKey, $baseUrl)
    {
        $this->line("  Deleting Vapi Assistant: {$character->vapi_assistant_id}");
        try {
            $response = Http::withToken($apiKey)->delete("{$baseUrl}/assistant/{$character->vapi_assistant_id}");
            if ($response->successful() || $response->status() === 404 || $response->status() === 400) {
                $character->update(['vapi_assistant_id' => null]);
                $this->info("  Deleted successfully (or already gone).");
            } else {
                $this->error("  Failed to delete: " . $response->body());
            }
        } catch (\Exception $e) {
            $this->error("  Error deleting: " . $e->getMessage());
        }
    }

    protected function syncVapiAssistant(AiCharacter $character, $apiKey, $baseUrl)
    {
        $prompt = $this->prepareAgentPrompt($character);
        $voice = $this->getVoiceForCharacter($character);
        
        // Force HTTPS for Vapi webhooks as it is mandatory
        $webhookUrl = str_replace('http://', 'https://', route('vapi.webhook'));

        $assistantData = [
            'name'         => $character->name,
            'firstMessage' => "Hi there, I'm {$character->name}, your business companion. How can I help you today?",
            'model'        => [
                'provider'    => 'openai',
                'model'       => 'gpt-4o-mini',
                'temperature' => 0.8,
                'maxTokens'   => 250,
                'messages'    => [
                    [
                        'role'    => 'system',
                        'content' => $prompt
                    ]
                ],
                'systemPrompt' => $prompt,
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
            'voice' => $voice,
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
                'recordingEnabled' => false,
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

    protected function getVoiceForCharacter(AiCharacter $character): array
    {
        $name = strtolower($character->name);
        $femaleNames = ['jessica', 'emily', 'nicole', 'bianca', 'isla', 'rozlyn', 'marceline', 'selene', 'nadia', 'lilith', 'vera', 'kira', 'monica', 'cassidy'];
        
        $isFemale = in_array($name, $femaleNames) || ($character->meta['gender'] ?? '') === 'female';

        if ($isFemale) {
            return [
                'provider' => 'deepgram',
                'voiceId'  => 'asteria',
            ];
        }

        return [
            'provider' => 'deepgram',
            'voiceId'  => 'orion',
        ];
    }

    protected function prepareAgentPrompt(AiCharacter $character): string
    {
        return "{{full_system_prompt}}";
    }
}


