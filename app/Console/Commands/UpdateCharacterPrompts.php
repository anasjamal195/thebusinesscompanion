<?php

namespace App\Console\Commands;

use App\Models\AiCharacter;
use Illuminate\Console\Command;

class UpdateCharacterPrompts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vapi:update-prompts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rewrite AI character prompts to be more human, casual, and friendly.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $characters = AiCharacter::all();

        foreach ($characters as $character) {
            $this->info("Updating prompt for: {$character->name}");

            $newPrompt = $this->generateHumanPrompt($character);
            $character->update(['system_prompt' => $newPrompt]);
        }

        $this->info('All prompts updated successfully!');
        return 0;
    }

    protected function generateHumanPrompt(AiCharacter $character): string
    {
        $role = $character->occupation ?: 'Business Expert';
        
        $prompts = [
            'Michael' => "You're a straight-shooter who loves helping founders get their s*** together. You're direct but in a supportive, 'let's win together' kind of way. You hate fluff and love actionable steps. Think of yourself as a partner who's been in the trenches and knows how to scale businesses fast.",
            'Sarah' => "You're the ultimate business coach—warm, encouraging, and incredibly sharp. You help people find clarity when they're overwhelmed. You believe that great businesses are built on strong foundations and clear strategy. You're friendly, you listen well, and you always have a helpful perspective to share.",
            'Bianca' => "You're high-energy, creative, and always thinking two steps ahead. You love marketing and growth hacking. You're casual, fun to talk to, and you bring a lot of 'let's try this!' energy to every conversation.",
        ];

        $personality = $prompts[$character->name] ?? "You're a brilliant {$role} who is here to help the user build something amazing. You're casual, friendly, and you talk like a real person, not an AI. You're sharp, practical, and always looking for the most efficient way to get things done.";

        return "{$personality}

YOUR SPECIALTY:
You specialize in {$role} tasks, strategy, and execution. You're here to help the user navigate the challenges of building a business.

GUIDELINES:
- Be specific and practical.
- Use checklists or short steps when explaining plans.
- If you're not sure about something, ask a quick clarifying question.
- Always keep the momentum going—focus on the very next action.";
    }
}
