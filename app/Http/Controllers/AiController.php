<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenRouterService;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    public function chat(Request $request, OpenRouterService $openRouter)
    {
        $validated = $request->validate([
            'chat_prompt' => ['required', 'string', 'max:8000'],
        ]);

        try {
            $response = $openRouter->chatCompletion([
                ['role' => 'user', 'content' => $validated['chat_prompt']],
            ], stream: false, maxTokens: 800);

            $text = (string) ($response->json('choices.0.message.content') ?? '');

            return back()->withInput()->with('ai_chat_response', $text);
        } catch (\Throwable $e) {
            Log::error('AI chat failed.', ['error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['chat_prompt' => 'AI request failed. Check logs.']);
        }
    }

    public function image(Request $request, OpenRouterService $openRouter)
    {
        $validated = $request->validate([
            'image_prompt' => ['required', 'string', 'max:2000'],
        ]);

        try {
            $url = $openRouter->generateImage($validated['image_prompt']);

            if (!$url) {
                return back()->withInput()->withErrors(['image_prompt' => 'Image generation failed.']);
            }

            return back()->withInput()->with('ai_image_url', $url);
        } catch (\Throwable $e) {
            Log::error('AI image failed.', ['error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['image_prompt' => 'Image generation failed. Check logs.']);
        }
    }
}
