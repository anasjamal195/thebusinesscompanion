<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiVisionService
{
    public function __construct(
        private readonly ?string $apiKey = null,
        private readonly ?string $model = null
    ) {
    }

    public function analyzeImage(string $path, string $mimeType, string $userText = ''): array
    {
        return $this->generateStructuredAnalysis([
            [
                'type' => 'image_url',
                'image_url' => [
                    'url' => 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($path)),
                ],
            ],
        ], $userText, 'image');
    }

    private function generateStructuredAnalysis(array $mediaParts, string $userText, string $mediaKind): array
    {
        $apiKey = $this->apiKey ?? config('services.openrouter.api_key');
        $model = $this->model ?? config('services.openrouter.vision_model', 'google/gemini-2.5-flash-lite');

        if (!$apiKey) {
            throw new \RuntimeException('OpenRouter API key is not configured.');
        }

        $schemaPrompt = <<<PROMPT
Analyze the user's {$mediaKind} input and return strict JSON only with this exact shape:
{
  "summary": "string",
  "objects": ["string"],
  "actions": "string",
  "text_detected": "string",
  "context": "string",
  "intent_guess": "string",
  "confidence": 0.0
}
PROMPT;

        if ($userText !== '') {
            $schemaPrompt .= "\nUser message for extra intent context: {$userText}";
        }

        $parts = array_merge([['type' => 'text', 'text' => $schemaPrompt]], $mediaParts);

        $response = Http::timeout(120)
            ->withOptions(['verify' => app()->environment('local') ? false : true])
            ->withToken($apiKey)
            ->withHeaders([
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])
            ->post(config('services.openrouter.base_url', 'https://openrouter.ai/api/v1') . '/chat/completions', [
                'model' => $model,
                'messages' => [[
                    'role' => 'user',
                    'content' => $parts,
                ]],
                'temperature' => 0.1,
                'response_format' => ['type' => 'json_object'],
            ]);

        if (!$response->successful()) {
            Log::error('OpenRouter vision request failed.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \RuntimeException('Vision analysis failed.');
        }

        $text = $response->json('choices.0.message.content', '{}');
        $decoded = json_decode($text, true);

        if (!is_array($decoded)) {
            throw new \RuntimeException('Vision analysis returned invalid JSON.');
        }

        return [
            'summary' => (string) ($decoded['summary'] ?? ''),
            'objects' => array_values(array_filter((array) ($decoded['objects'] ?? []), fn ($value) => is_string($value) && $value !== '')),
            'actions' => (string) ($decoded['actions'] ?? ''),
            'text_detected' => (string) ($decoded['text_detected'] ?? ''),
            'context' => (string) ($decoded['context'] ?? ''),
            'intent_guess' => (string) ($decoded['intent_guess'] ?? ''),
            'confidence' => max(0, min(1, (float) ($decoded['confidence'] ?? 0))),
        ];
    }
}

