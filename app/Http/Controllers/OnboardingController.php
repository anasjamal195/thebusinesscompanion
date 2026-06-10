<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function schedule()
    {
        $user = Auth::user();
        return view('onboarding.schedule', compact('user'));
    }

    public function saveSchedule(Request $request)
    {
        $validated = $request->validate([
            'morning_call_time'     => ['required', 'date_format:H:i'],
            'timezone'              => ['required', 'timezone'],
            'default_delay_minutes' => ['nullable', 'integer', 'min:1'],
            'voice_id'              => ['required', 'string'],
            'phone_number'          => ['nullable', 'string', 'regex:/^(\+1\d{10})?$/'],
            'calling_preference'    => ['sometimes', 'in:app,phone'],
        ]);

        $user = Auth::user();
        $user->update([
            'morning_call_time'     => $validated['morning_call_time'],
            'timezone'              => $validated['timezone'],
            'default_delay_minutes' => $validated['default_delay_minutes'] ?? null,
            'voice_id'              => $validated['voice_id'],
            'calling_preference'    => $validated['calling_preference'] ?? $user->calling_preference ?? 'app',
        ]);

        if ($request->filled('phone_number')) {
            $profile = $user->profile;
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone_number'  => $validated['phone_number'],
                    'business_name' => $profile ? $profile->business_name : ($user->name . "'s Business"),
                    'business_type' => $profile ? $profile->business_type : 'Agency',
                ]
            );
        }

        return redirect()->route('dashboard');
    }

    public static function getNextOnboardingRoute($user)
    {
        if (!$user->morning_call_time) {
            return route('onboarding.schedule');
        }

        return route('dashboard');
    }
}
