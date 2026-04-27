<?php

namespace App\Http\Controllers;

use App\Models\AiCharacter;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new UserProfile();
        $companions = AiCharacter::all();
        
        return view('settings', compact('user', 'profile', 'companions'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'business_name' => 'required|string|max:255',
            'business_url' => 'nullable|url|max:255',
            'business_description' => 'required|string',
            'industry' => 'required|string|max:255',
            'experience_level' => 'required|in:beginner,intermediate,expert',
            'companion_id' => 'required|exists:ai_characters,id',
            'current_problems' => 'nullable|string',
            'urgent_tasks' => 'nullable|string',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'companion_id' => $validated['companion_id'],
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'business_name' => $validated['business_name'],
                'business_url' => $validated['business_url'],
                'business_description' => $validated['business_description'],
                'industry' => $validated['industry'],
                'experience_level' => $validated['experience_level'],
                'current_problems' => $validated['current_problems'],
                'urgent_tasks' => $validated['urgent_tasks'],
            ]
        );

        return back()->with('success', 'Settings updated successfully.');
    }
}
