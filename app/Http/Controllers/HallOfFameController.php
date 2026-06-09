<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\User;
use App\Services\AchievementService;

class HallOfFameController extends Controller
{
    public function __construct(
        protected AchievementService $achievementService
    ) {}

    public function index()
    {
        $longestStreaks = User::where('execution_score', '>', 0)
            ->orderBy('execution_score', 'desc')
            ->take(10)
            ->get()
            ->map(function ($user) {
                $streak = $this->achievementService->calculateStreak($user);
                $user->current_streak = $streak;

                return $user;
            })
            ->sortByDesc('current_streak')
            ->take(10);

        $highestScores = User::where('execution_score', '>', 0)
            ->orderBy('execution_score', 'desc')
            ->take(10)
            ->get();

        $mostTasksCompleted = User::whereHas('achievements', function ($q) {
            $q->whereIn('achievements.key', ['1000_tasks', '100_tasks', '10_tasks']);
        })
            ->take(10)
            ->get()
            ->sortByDesc(function ($user) {
                return $user->tasks()->where('status', 'completed')->count();
            })
            ->take(10);

        $challengeWinners = User::whereHas('challengeParticipants', function ($q) {
            $q->whereNotNull('completed_at');
        })
            ->take(10)
            ->get();

        $mentors = Mentor::active()
            ->with('user')
            ->latest('mentees_count')
            ->take(10)
            ->get();

        return view('hall-of-fame.index', compact(
            'longestStreaks', 'highestScores', 'mostTasksCompleted', 'challengeWinners', 'mentors'
        ));
    }
}
