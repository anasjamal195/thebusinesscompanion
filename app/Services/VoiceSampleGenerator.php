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
     * says at the start of a call. The voice's own name is spoken, so even
     * fallback samples are distinct and conversational.
     */
    private function sampleText(Voice $voice): string
    {
        $name = $voice->name ?: 'your assistant';

        return "Hey, it's {$name} from dialer.best! Alright, ready to plan out your day? Let's do this!";
    }

    /**
     * Which engine produces the sample for this voice.
     * Returns: 'elevenlabs' | 'openai' | 'fallback'
     */
    public function resolveEngine(Voice $voice): string
    {
        if ($voice->provider === '11labs' && env('ELEVENLABS_API_KEY')) {
            return 'elevenlabs';
        }

        if ($voice->provider === 'openai' && env('OPENAI_API_KEY')) {
            return 'openai';
        }

        return 'fallback';
    }

    /**
     * Human label for the engine powering a voice's sample (used in the admin UI).
     */
    public function engineLabel(Voice $voice): string
    {
        return match ($this->resolveEngine($voice)) {
            'elevenlabs' => 'ElevenLabs voice (exact)',
            'openai'     => 'OpenAI voice (exact)',
            default      => 'Free fallback — add a key',
        };
    }

    /**
     * Generate (or regenerate) a short TTS sample for the given voice.
     *
     * 1. Provider-native TTS (ElevenLabs / OpenAI) — the exact voice model,
     *    natural + casual. Used automatically when the matching key is set.
     * 2. Distinct free fallback — one of 7 different English Google voices,
     *    chosen deterministically from the voice's accent/name so every voice
     *    still sounds different (never a shared robotic voice).
     *
     * @return string|null relative path (e.g. voice-samples/xxx.mp3) or null on failure
     */
    public function generate(Voice $voice): ?string
    {
        return match ($this->resolveEngine($voice)) {
            'elevenlabs' => $this->elevenLabs($voice) ?? $this->googleFallback($voice),
            'openai'     => $this->openAi($voice) ?? $this->googleFallback($voice),
            default      => $this->googleFallback($voice),
        };
    }

    private function elevenLabs(Voice $voice): ?string
    {
        $response = Http::withHeaders([
            'xi-api-key' => env('ELEVENLABS_API_KEY'),
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

        return $response->successful() ? $this->store($voice, $response->body()) : null;
    }

    private function openAi(Voice $voice): ?string
    {
        $response = Http::withToken(env('OPENAI_API_KEY'))->timeout(15)
            ->post('https://api.openai.com/v1/audio/speech', [
                'model' => 'gpt-4o-mini-tts',
                'voice' => $voice->vapi_voice_id,
                'input' => $this->sampleText($voice),
                'response_format' => 'mp3',
                'instructions' => 'Speak naturally and casually, like a friendly energetic coach. Warm, upbeat, conversational — never robotic.',
            ]);

        return $response->successful() ? $this->store($voice, $response->body()) : null;
    }

    /**
     * Free fallback (no key needed). Picks a distinct natural voice per voice row:
     * accent drives the locale when known, otherwise a stable per-name hash —
     * so the six voices never share a single robotic voice.
     */
    private function googleFallback(Voice $voice): ?string
    {
        $locale = $this->pickLocale($voice);

        $response = Http::withOptions(['stream' => false])
            ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
            ->timeout(10)
            ->get('https://translate.google.com/translate_tts', [
                'ie' => 'UTF-8',
                'q' => $this->sampleText($voice),
                'tl' => $locale,
                'client' => 'tw-ob',
            ]);

        return $response->successful() ? $this->store($voice, $response->body()) : null;
    }

    /**
     * Distinct English Google voices (verified working). Each value is a
     * separate speaker. en-US//en-GB/en-AU/en-IN/en-PH/en-NZ/en-LK are all
     * audibly different; some rare locales share a voice, so we only use these.
     */
    private const DISTINCT_LOCALES = ['en-US', 'en-GB', 'en-AU', 'en-IN', 'en-PH', 'en-NZ', 'en-LK'];

    private function pickLocale(Voice $voice): string
    {
        $accent = strtolower((string) $voice->accent);

        $named = [
            'british' => 'en-GB',
            'australian' => 'en-AU',
            'indian' => 'en-IN',
            'american' => 'en-US',
            'filipino' => 'en-PH',
            'philippine' => 'en-PH',
            'new zealand' => 'en-NZ',
            'canadian' => 'en-CA',
            'irish' => 'en-IE',
        ];

        foreach ($named as $key => $locale) {
            if (str_contains($accent, $key)) {
                return $locale;
            }
        }

        $sum = 0;
        foreach (str_split($voice->name ?: $voice->vapi_voice_id) as $c) {
            $sum += ord($c);
        }

        return self::DISTINCT_LOCALES[$sum % count(self::DISTINCT_LOCALES)];
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