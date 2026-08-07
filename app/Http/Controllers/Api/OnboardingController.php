<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function saveSchedule(Request $request)
    {
        $validated = $request->validate([
            'morning_call_time' => ['required', 'date_format:H:i'],
            'timezone' => ['required', 'timezone'],
            'default_delay_minutes' => ['nullable', 'integer', 'min:1'],
            'off_days' => ['nullable', 'array'],
            'off_days.*' => ['integer', 'between:1,7'],
            'voice_id' => ['required', 'string'],
            'phone_number' => ['nullable', 'string'],
            'calling_preference' => ['nullable', 'in:phone,app'],
        ]);

        $user = $request->user();
        $user->update([
            'morning_call_time' => $validated['morning_call_time'],
            'timezone' => $validated['timezone'],
            'default_delay_minutes' => $validated['default_delay_minutes'] ?? null,
            'off_days' => $validated['off_days'] ?? [],
            'voice_id' => $validated['voice_id'],
            'calling_preference' => $validated['calling_preference'] ?? 'phone',
            'onboarding_completed' => true,
        ]);

        if ($request->filled('phone_number')) {
            $profile = $user->profile;
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone_number' => $validated['phone_number'],
                    'business_name' => $profile?->business_name ?? $user->name . "'s Business",
                    'business_type' => $profile?->business_type ?? 'Agency',
                ]
            );
        }

        return response()->json(['user' => $user->fresh()->load('profile')]);
    }
}
