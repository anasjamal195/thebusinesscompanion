<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Psr\Http\Message\StreamInterface;

class OpenRouterService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $model;
    protected ?string $falKey;

    public function __construct()
    {
        $this->apiKey = (string) config('services.openrouter.api_key', '');
        $this->baseUrl = (string) config('services.openrouter.base_url', 'https://openrouter.ai/api/v1');
        $this->model = (string) config('services.openrouter.model', 'deepseek/deepseek-chat');
        $this->falKey = config('services.fal.key');
    }

    public function chatCompletion(array $messages, bool $stream = false, int $maxTokens = 300)
    {
        if ($this->apiKey === '') {
            throw new \RuntimeException('OpenRouter API key is not configured.');
        }

        $payload = [
            'model' => $this->model,
            'messages' => $messages,
            'stream' => $stream,
            'max_tokens' => $maxTokens,
        ];

        $client = Http::withToken($this->apiKey)
            ->withOptions(['verify' => app()->environment('local') ? false : true])
            ->withHeaders([
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ]);

        if ($stream) {
            return $client
                ->withOptions(['stream' => true])
                ->timeout(60)
                ->post("{$this->baseUrl}/chat/completions", $payload);
        }

        return $client
            ->timeout(180)
            ->post("{$this->baseUrl}/chat/completions", $payload);
    }

    /**
     * Stream chat completion text deltas from OpenRouter.
     *
     * Yields strings (delta content). Caller is responsible for concatenation.
     */
    public function streamChatCompletion(array $messages, int $maxTokens = 800): \Generator
    {
        $response = $this->chatCompletion($messages, true, $maxTokens);
        if (!$response->successful()) {
            throw new \RuntimeException('OpenRouter stream request failed: ' . $response->status());
        }

        $psr = $response->toPsrResponse();
        /** @var StreamInterface $body */
        $body = $psr->getBody();

        $buffer = '';
        while (!$body->eof()) {
            $chunk = $body->read(8192);
            if ($chunk === '') {
                usleep(20_000);
                continue;
            }

            $buffer .= $chunk;

            while (($pos = strpos($buffer, "\n")) !== false) {
                $line = substr($buffer, 0, $pos);
                $buffer = substr($buffer, $pos + 1);

                $line = trim($line);
                if ($line === '' || !str_starts_with($line, 'data:')) {
                    continue;
                }

                $payload = trim(substr($line, 5));
                if ($payload === '[DONE]') {
                    return;
                }

                $json = json_decode($payload, true);
                if (!is_array($json)) {
                    continue;
                }

                $delta = $json['choices'][0]['delta']['content'] ?? null;
                if (is_string($delta) && $delta !== '') {
                    yield $delta;
                }
            }
        }
    }

    public function generateImage(string $prompt): ?string
    {
        $urls = $this->generateMultipleImages($prompt, 1);
        $url = $urls[0] ?? null;

        if (!$url) {
            // Basic fallback if Fal fails (remote URL, no storage).
            $safe = mb_substr($prompt, 0, 250);
            $url = "https://image.pollinations.ai/prompt/" . rawurlencode($safe) . "?width=1024&height=1024&nologo=true&model=flux";
        }

        return $url;
    }

    public function generateMultipleImages(string $prompt, int $count = 3): array
    {
        $rephrasedPrompt = $this->rephrasePromptForSafety($prompt);

        if (!$this->falKey) {
            Log::error('Fal.ai key is not configured.');
            return [];
        }

        try {
            $responses = Http::pool(function ($pool) use ($count, $rephrasedPrompt) {
                return collect(range(1, $count))
                    ->map(fn () => $pool
                        ->withOptions(['verify' => app()->environment('local') ? false : true])
                        ->withHeaders([
                            'Authorization' => "Key {$this->falKey}",
                            'Content-Type' => 'application/json',
                        ])
                        ->timeout(180)
                        ->post('https://fal.run/fal-ai/flux-1/schnell', [
                            'prompt' => $rephrasedPrompt,
                            'image_size' => 'square_hd',
                        ]))
                    ->toArray();
            });

            $imageUrls = [];

            foreach ($responses as $response) {
                if (!$response->successful()) {
                    Log::error('Fal.ai image generation failed.', ['body' => $response->body()]);
                    continue;
                }

                $remoteUrl = $response->json('images.0.url');
                if (!$remoteUrl) {
                    continue;
                }

                $imageContent = Http::timeout(60)->get($remoteUrl)->body();
                if ($imageContent === '') {
                    continue;
                }

                $filename = 'generated_' . time() . '_' . uniqid('', true) . '.jpg';
                $path = 'generated_images/' . $filename;
                Storage::disk('public')->put($path, $imageContent);

                $imageUrls[] = asset('storage/' . $path);
            }

            return $imageUrls;
        } catch (\Throwable $e) {
            Log::error('Exception during Fal.ai image generation.', ['error' => $e->getMessage()]);
            return [];
        }
    }

    public function rephrasePromptForSafety(string $prompt): string
    {
        $messages = [
            [
                'role' => 'system',
                'content' => 'Rewrite user image prompts into safe, non-explicit, artistic descriptions. Output only the rewritten prompt. No refusals, no commentary.',
            ],
            [
                'role' => 'user',
                'content' => 'Rephrase this prompt: ' . $prompt,
            ],
        ];

        try {
            $response = $this->chatCompletion($messages, false, 250);
            if ($response && $response->successful()) {
                $rephrased = (string) $response->json('choices.0.message.content', '');
                return trim($rephrased) !== '' ? trim($rephrased) : $prompt;
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to rephrase prompt.', ['error' => $e->getMessage()]);
        }

        return $prompt;
    }
}
