<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeParticipant;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeChallenges = Challenge::active()
            ->where('end_date', '>=', now()->toDateString())
            ->withCount('participants')
            ->get();

        $pastChallenges = Challenge::where('end_date', '<', now()->toDateString())
            ->withCount('participants')
            ->latest('end_date')
            ->take(10)
            ->get();

        $userParticipations = ChallengeParticipant::where('user_id', $user->id)
            ->with('challenge')
            ->get()
            ->keyBy('challenge_id');

        return view('challenges.index', compact(
            'activeChallenges', 'pastChallenges', 'userParticipations', 'user'
        ));
    }

    public function show(Challenge $challenge)
    {
        $user = Auth::user();
        $participants = $challenge->participants()
            ->with('user')
            ->latest('joined_at')
            ->take(50)
            ->get();

        $userParticipation = ChallengeParticipant::where('challenge_id', $challenge->id)
            ->where('user_id', $user->id)
            ->first();

        $participantCount = $challenge->participants()->count();

        return view('challenges.show', compact(
            'challenge', 'participants', 'userParticipation', 'participantCount', 'user'
        ));
    }

    public function join(Challenge $challenge)
    {
        $user = Auth::user();

        $existing = ChallengeParticipant::where('challenge_id', $challenge->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You are already participating in this challenge.');
        }

        ChallengeParticipant::create([
            'challenge_id' => $challenge->id,
            'user_id' => $user->id,
            'progress_data' => [],
        ]);

        return back()->with('success', 'You joined the challenge!');
    }
}
