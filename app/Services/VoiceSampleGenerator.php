<?php

namespace App\Services;

use App\Models\Voice;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VoiceSampleGenerator
{
    /**
     * Casual, natural first-message style text — mirrors what the voice actually
     * says at the start of a call. This matters more than the engine for the
     * "natural & casual" feel of the preview.
     */
    private function sampleText(Voice $voice): string
    {
        $name = $voice->name ?: 'your assistant';

        return "Hey, it's {$name} from dialer.best! Alright, ready to plan out your day? Let's do this!";
    }

    /**
     * Generate (or regenerate) a short TTS sample for the given voice provider.
     *
     * Order of preference:
     *  1. Provider-native TTS (ElevenLabs / OpenAI) — natural, matches the real voice
     *  2. Google Translate TTS — free fallback (functional, less expressive)
     *
     * @return string|null relative path (e.g. voice-samples/xxx.mp3) or null on failure
     */
    public function generate(Voice $voice): ?string
    {
        return match ($voice->provider) {
            '11labs' => $this->elevenLabs($voice) ?? $this->googleFallback($voice),
            'openai' => $this->openAi($voice) ?? $this->googleFallback($voice),
            default  => $this->googleFallback($voice),
        };
    }

    private function elevenLabs(Voice $voice): ?string
    {
        $key = env('ELEVENLABS_API_KEY');
        if (!$key) {
            return null;
        }

        $response = Http::withHeaders([
            'xi-api-key' => $key,
            'Content-Type' => 'application/json',
        ])->timeout(20)->post("https://api.elevenlabs.io/v1/text-to-speech/{$voice->vapi_voice_id}", [
            'text' => $this->sampleText($voice),
            // Turbo model = fast + expressive; keeps the sample lively, not monotone
            'model_id' => 'eleven_turbo_v2_5',
            'voice_settings' => [
                // Lower stability + slight style = more natural, conversational delivery
                'stability' => 0.35,
                'similarity_boost' => 0.75,
                'style' => 0.45,
                'use_speaker_boost' => true,
            ],
        ]);

        if ($response->successful()) {
            return $this->store($voice, $response->body());
        }

        return null;
    }

    private function openAi(Voice $voice): ?string
    {
        $key = env('OPENAI_API_KEY');
        if (!$key) {
            return null;
        }

        $response = Http::withToken($key)->timeout(15)
            ->post('https://api.openai.com/v1/audio/speech', [
                'model' => 'gpt-4o-mini-tts',
                'voice' => $voice->vapi_voice_id,
                'input' => $this->sampleText($voice),
                'response_format' => 'mp3',
                'instructions' => 'Speak naturally and casually, like a friendly energetic coach. Warm, upbeat, conversational — never robotic.',
            ]);

        if ($response->successful()) {
            return $this->store($voice, $response->body());
        }

        return null;
    }

    /**
     * Free fallback (no key needed). Not as expressive as ElevenLabs/OpenAI,
     * but the casual copy keeps the sample from sounding stiff.
     */
    private function googleFallback(Voice $voice): ?string
    {
        $locale = strtolower($voice->accent ?? '') === 'british' ? 'en-GB' : 'en-US';

        $response = Http::withOptions(['stream' => false])
            ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
            ->timeout(10)
            ->get('https://translate.google.com/translate_tts', [
                'ie' => 'UTF-8',
                'q' => $this->sampleText($voice),
                'tl' => $locale,
                'client' => 'tw-ob',
            ]);

        if ($response->successful()) {
            return $this->store($voice, $response->body());
        }

        return null;
    }

    private function store(Voice $voice, string $audio): ?string
    {
        $path = 'voice-samples/' . Str::slug($voice->name) . '-' . Str::lower(Str::random(6)) . '.mp3';
        Storage::disk('public')->put($path, $audio);

        if ($voice->sample_path) {
            Storage::disk('public')->delete($voice->sample_path);
        }

        return $path;
    }
}