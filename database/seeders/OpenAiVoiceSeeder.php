<?php

namespace Database\Seeders;

use App\Models\Voice;
use Illuminate\Database\Seeder;

class OpenAiVoiceSeeder extends Seeder
{
    public function run(): void
    {
        $voices = [
            [
                'name' => 'Nova',
                'vapi_voice_id' => 'nova',
                'provider' => 'openai',
                'gender' => 'Female',
                'accent' => 'American',
                'description' => 'Friendly & Supportive',
                'sort_order' => 7,
            ],
            [
                'name' => 'Alloy',
                'vapi_voice_id' => 'alloy',
                'provider' => 'openai',
                'gender' => 'Female',
                'accent' => 'American',
                'description' => 'Versatile & Balanced',
                'sort_order' => 8,
            ],
        ];

        foreach ($voices as $voice) {
            Voice::updateOrCreate(
                ['vapi_voice_id' => $voice['vapi_voice_id']],
                array_merge($voice, ['is_active' => true])
            );
        }

        $this->command->info(count($voices) . ' OpenAI voices seeded.');
    }
}