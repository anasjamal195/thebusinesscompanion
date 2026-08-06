<?php

namespace Database\Seeders;

use App\Models\Voice;
use Illuminate\Database\Seeder;

class VoiceSeeder extends Seeder
{
    public function run(): void
    {
        $voices = [
            ['name' => 'Jessica', 'vapi_voice_id' => 'cgSgspJ2msm6clMCkdW9', 'gender' => 'Female', 'accent' => 'American', 'description' => 'Warm & Friendly', 'sort_order' => 1],
            ['name' => 'Liam', 'vapi_voice_id' => 'TX3LPaxmHKxFdv7VOQHJ', 'gender' => 'Male', 'accent' => 'American', 'description' => 'Casual & Motivating', 'sort_order' => 2],
            ['name' => 'Sarah', 'vapi_voice_id' => 'EXAVITQu4vr4xnSDxMaL', 'gender' => 'Female', 'accent' => 'British', 'description' => 'Professional & Clear', 'sort_order' => 3],
            ['name' => 'Will', 'vapi_voice_id' => 'bIHbv24MWmeRgasZH58o', 'gender' => 'Male', 'accent' => 'American', 'description' => 'Energetic & Upbeat', 'sort_order' => 4],
            ['name' => 'Charlotte', 'vapi_voice_id' => 'XB0fDUnXU5powFXDhCwa', 'gender' => 'Female', 'accent' => 'British', 'description' => 'Calm & Focused', 'sort_order' => 5],
            ['name' => 'Brian', 'vapi_voice_id' => 'nPczCjzI2devNBz1zQrb', 'gender' => 'Male', 'accent' => 'American', 'description' => 'Deep & Authoritative', 'sort_order' => 6],
        ];

        foreach ($voices as $voice) {
            Voice::updateOrCreate(
                ['vapi_voice_id' => $voice['vapi_voice_id']],
                array_merge($voice, ['provider' => '11labs', 'is_active' => true])
            );
        }

        $this->command->info(count($voices) . ' default voices seeded.');
    }
}