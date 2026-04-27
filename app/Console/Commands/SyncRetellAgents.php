<?php

namespace App\Console\Commands;

use App\Models\AiCharacter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncRetellAgents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retell:sync-agents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync AI Characters from database to Retell AI Agents with dynamic prompts (V2 Architecture)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = config('services.retell.api_key');
        $baseUrl = 'https://api.retellai.com';

        if (!$apiKey) {
            $this->error('RETELL_API_KEY is not configured in services.php');
            return 1;
        }

        $characters = AiCharacter::all();

        foreach ($characters as $character) {
            $this->info("Processing character: {$character->name}");

            // Step 1: Create or Update Retell LLM (where the prompt lives)
            $llmId = $this->syncRetellLlm($character, $apiKey, $baseUrl);
            
            if (!$llmId) {
                $this->error("Skipping agent sync for {$character->name} due to LLM failure.");
                continue;
            }

            // Step 2: Create or Update Retell Agent (where voice and telephony live)
            $this->syncRetellAgent($character, $llmId, $apiKey, $baseUrl);
        }

        $this->info('Sync completed!');
        return 0;
    }

    protected function syncRetellLlm(AiCharacter $character, $apiKey, $baseUrl)
    {
        $prompt = $this->prepareAgentPrompt($character);
        
        $llmData = [
            'general_prompt' => $prompt,
            'begin_message' => "Hi there, I'm {$character->name}. How can I help you today?",
        ];

        try {
            if ($character->retell_llm_id) {
                $this->line("Updating existing Retell LLM: {$character->retell_llm_id}");
                $response = Http::withToken($apiKey)
                    ->patch("{$baseUrl}/v2/update-retell-llm/{$character->retell_llm_id}", $llmData);
            } else {
                $this->line("Creating new Retell LLM...");
                $response = Http::withToken($apiKey)
                    ->post("{$baseUrl}/v2/create-retell-llm", $llmData);
            }

            if ($response->successful()) {
                $llmId = $response->json('llm_id');
                if (!$character->retell_llm_id) {
                    $character->update(['retell_llm_id' => $llmId]);
                }
                return $llmId;
            }

            $this->error("Failed to sync LLM for {$character->name}: " . $response->body());
        } catch (\Exception $e) {
            $this->error("Error syncing LLM for {$character->name}: " . $e->getMessage());
        }

        return null;
    }

    protected function syncRetellAgent(AiCharacter $character, $llmId, $apiKey, $baseUrl)
    {
        $agentData = [
            'agent_name' => "Companion: " . $character->name,
            'voice_id' => $character->meta['voice_id'] ?? '11labs-Adrian',
            'llm_id' => $llmId,
            'webhook_url' => config('app.url') . '/retell/webhook',
            'avatar_url' => $character->avatar_url,
        ];

        try {
            if ($character->retell_agent_id) {
                $this->line("Updating existing Retell Agent: {$character->retell_agent_id}");
                $response = Http::withToken($apiKey)
                    ->patch("{$baseUrl}/v2/update-agent/{$character->retell_agent_id}", $agentData);
            } else {
                $this->line("Creating new Retell Agent...");
                $response = Http::withToken($apiKey)
                    ->post("{$baseUrl}/v2/create-agent", $agentData);
            }

            if ($response->successful()) {
                $agentId = $response->json('agent_id');
                if (!$character->retell_agent_id) {
                    $character->update(['retell_agent_id' => $agentId]);
                }
                $this->info("Successfully synced agent for {$character->name}");
                return $agentId;
            }

            $this->error("Failed to sync agent for {$character->name}: " . $response->body());
        } catch (\Exception $e) {
            $this->error("Error syncing agent for {$character->name}: " . $e->getMessage());
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
