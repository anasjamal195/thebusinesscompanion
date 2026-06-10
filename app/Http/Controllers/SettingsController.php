<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new UserProfile();

        return view('settings', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'voice_id' => 'required|string',
            'calling_preference' => 'sometimes|in:app,phone',
            'morning_call_time' => 'sometimes|date_format:H:i',
            'timezone' => 'sometimes|timezone',
            'default_delay_minutes' => 'nullable|integer|min:1',
            'phone_number' => 'nullable|string|regex:/^(\+1\d{10})?$/',
            'profile_privacy' => 'sometimes|in:public,private',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'voice_id' => $validated['voice_id'],
            'calling_preference' => $validated['calling_preference'] ?? $user->calling_preference,
            'morning_call_time' => $validated['morning_call_time'] ?? $user->morning_call_time,
            'timezone' => $validated['timezone'] ?? $user->timezone,
            'default_delay_minutes' => $validated['default_delay_minutes'] ?? $user->default_delay_minutes,
            'community_participation_mode' => $validated['profile_privacy'] ?? $user->community_participation_mode,
        ]);

        if ($request->has('phone_number')) {
            $profile = $user->profile;
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone_number' => $validated['phone_number'],
                    'business_name' => $profile ? $profile->business_name : ($user->name . "'s Business"),
                    'business_type' => $profile ? $profile->business_type : 'Agency',
                ]
            );
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
