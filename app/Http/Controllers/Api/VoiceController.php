<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voice;

class VoiceController extends Controller
{
    public function index()
    {
        $voices = Voice::activeOrdered();

        return response()->json([
            'voices' => $voices->map(fn (Voice $voice) => [
                'id' => $voice->vapi_voice_id,
                'name' => $voice->name,
                'provider' => $voice->provider,
                'gender' => $voice->gender,
                'accent' => $voice->accent,
                'description' => $voice->description,
                'avatar_url' => $voice->avatar_url,
                'sample_url' => $voice->sample_url,
            ]),
        ]);
    }
}