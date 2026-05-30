<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class VoicePreviewController extends Controller
{
    private array $localeMap = [
        'cgSgspJ2msm6clMCkdW9' => 'en-US',
        'TX3LPaxmHKxFdv7VOQHJ' => 'en-US',
        'EXAVITQu4vr4xnSDxMaL' => 'en-US',
        'bIHbv24MWmeRgasZH58o' => 'en-US',
        'XB0fDUnXU5powFXDhCwa' => 'en-GB',
        'nPczCjzI2devNBz1zQrb' => 'en-US',
    ];

    public function __invoke(string $voiceId)
    {
        $voiceId = urldecode($voiceId);
        $text = request('text', "Hi, I'm a voice assistant. Let me help you run your business today.");

        $elevenLabsKey = env('ELEVENLABS_API_KEY');
        if ($elevenLabsKey) {
            $response = Http::withHeaders([
                'xi-api-key' => $elevenLabsKey,
                'Content-Type' => 'application/json',
            ])->timeout(10)->post("https://api.elevenlabs.io/v1/text-to-speech/{$voiceId}", [
                'text' => $text,
                'model_id' => 'eleven_monolingual_v1',
                'voice_settings' => [
                    'stability' => 0.5,
                    'similarity_boost' => 0.5,
                ],
            ]);

            if ($response->successful()) {
                $contentType = $response->header('Content-Type') ?: 'audio/mpeg';
                return response($response->body(), 200, [
                    'Content-Type' => $contentType,
                ]);
            }
        }

        $locale = $this->localeMap[$voiceId] ?? 'en-US';
        $response = Http::withOptions(['stream' => false])
            ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
            ->timeout(10)
            ->get('https://translate.google.com/translate_tts', [
                'ie' => 'UTF-8',
                'q' => $text,
                'tl' => $locale,
                'client' => 'tw-ob',
            ]);

        if ($response->successful()) {
            return response($response->body(), 200, [
                'Content-Type' => 'audio/mpeg',
            ]);
        }

        return response()->json(['error' => 'Unable to generate voice preview'], 502);
    }
}
