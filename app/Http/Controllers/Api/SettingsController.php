<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('profile');

        return response()->json([
            'user' => $user,
            'profile' => $user->profile ?? new UserProfile(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'voice_id' => ['sometimes', 'string'],
            'morning_call_time' => ['sometimes', 'date_format:H:i'],
            'timezone' => ['sometimes', 'timezone'],
            'default_delay_minutes' => ['nullable', 'integer', 'min:1'],
        ]);

        $user->update($validated);

        return response()->json(['user' => $user->fresh()]);
    }
}
