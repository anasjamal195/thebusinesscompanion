<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorController extends Controller
{
    public function index()
    {
        $mentors = Mentor::active()
            ->with('user')
            ->latest('mentees_count')
            ->paginate(20);

        $user = Auth::user();
        $canBecomeMentor = $user->execution_score > 90
            && app(\App\Services\AchievementService::class)->calculateStreak($user) >= 60
            && $user->community_reputation > 0;

        return view('mentors.index', compact('mentors', 'user', 'canBecomeMentor'));
    }

    public function show(User $user)
    {
        $mentor = Mentor::where('user_id', $user->id)->with('user')->firstOrFail();

        $mentorPosts = \App\Models\CommunityPost::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('mentors.show', compact('mentor', 'mentorPosts'));
    }

    public function apply(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'bio' => 'required|string|max:2000',
            'specialties' => 'required|array|min:1|max:5',
            'specialties.*' => 'string|max:100',
        ]);

        if ($user->execution_score <= 90 || app(\App\Services\AchievementService::class)->calculateStreak($user) < 60) {
            return back()->with('error', 'You do not meet the requirements to become a mentor yet.');
        }

        Mentor::updateOrCreate(
            ['user_id' => $user->id],
            [
                'bio' => $validated['bio'],
                'specialties' => $validated['specialties'],
                'is_active' => true,
            ]
        );

        return back()->with('success', 'You are now a mentor! Welcome to the program.');
    }
}
