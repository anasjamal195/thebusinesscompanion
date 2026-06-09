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
            'community_participation_mode' => 'sometimes|in:private,social,hybrid',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'voice_id' => $validated['voice_id'],
            'community_participation_mode' => $validated['community_participation_mode'] ?? $user->community_participation_mode,
        ]);

        return back()->with('success', 'Settings updated successfully.');
    }
}
