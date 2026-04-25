<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AudioTranscriptionService
{
    public function transcribeFile(string $path, string $format): array
    {
        $apiKey = config('services.openrouter.api_key');
        $model = config('services.openrouter.stt_model', 'google/gemini-2.5-flash');
        $baseUrl = config('services.openrouter.base_url', 'https://openrouter.ai/api/v1');

        if (!$apiKey) {
            throw new \RuntimeException('OpenRouter API key is not configured.');
        }

        $audioData = base64_encode(file_get_contents($path));

        $response = Http::timeout(180)
            ->withToken($apiKey)
            ->withOptions(['verify' => app()->environment('local') ? false : true])
            ->withHeaders([
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])
            ->post($baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [[
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => 'Transcribe this audio. Return strict JSON only with keys: transcript, language, confidence, summary.',
                        ],
                        [
                            'type' => 'input_audio',
                            'input_audio' => [
                                'data' => $audioData,
                                'format' => $format,
                            ],
                        ],
                    ],
                ]],
                'temperature' => 0,
                'response_format' => ['type' => 'json_object'],
            ]);

        if (!$response->successful()) {
            Log::error('OpenRouter transcription request failed.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \RuntimeException('Audio transcription failed.');
        }

        $content = $response->json('choices.0.message.content', '{}');
        $decoded = json_decode($content, true);

        if (!is_array($decoded)) {
            throw new \RuntimeException('Audio transcription returned invalid JSON.');
        }

        return [
            'transcript' => trim((string) ($decoded['transcript'] ?? '')),
            'language' => trim((string) ($decoded['language'] ?? '')),
            'confidence' => max(0, min(1, (float) ($decoded['confidence'] ?? 0))),
            'summary' => trim((string) ($decoded['summary'] ?? '')),
        ];
    }
}

