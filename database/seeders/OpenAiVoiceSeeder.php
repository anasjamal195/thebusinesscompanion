<?php

namespace Database\Seeders;

use App\Models\Voice;
use App\Services\VoiceAvatarGenerator;
use Illuminate\Database\Seeder;

class OpenAiVoiceSeeder extends Seeder
{
    private const PALETTE = [
        'Nova' => '14B8A6',
        'Alloy' => '6366F1',
    ];

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

        $avatarGenerator = app(VoiceAvatarGenerator::class);

        foreach ($voices as $voice) {
            $row = Voice::updateOrCreate(
                ['vapi_voice_id' => $voice['vapi_voice_id']],
                array_merge($voice, ['is_active' => true])
            );

            if (!$row->avatar_path) {
                $path = $avatarGenerator->generate($row, self::PALETTE[$voice['name']] ?? '6366F1');
                if ($path) {
                    $row->update(['avatar_path' => $path]);
                }
            }
        }

        $this->command->info(count($voices) . ' OpenAI voices seeded.');
    }
}