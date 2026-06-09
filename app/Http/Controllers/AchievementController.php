<?php

namespace App\Http\Controllers;

use App\Services\AchievementService;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function __construct(
        protected AchievementService $achievementService
    ) {}

    public function index()
    {
        $user = Auth::user();

        $allAchievements = \App\Models\Achievement::ordered()->get()->groupBy('category');
        $earnedIds = $user->achievements()->pluck('achievements.id')->toArray();
        $recentEarned = $this->achievementService->getRecentAchievements($user, 10);
        $streak = $this->achievementService->calculateStreak($user);
        $executionScore = $user->execution_score;

        return view('achievements.index', compact(
            'allAchievements', 'earnedIds', 'recentEarned', 'streak', 'executionScore', 'user'
        ));
    }

    public function share(\App\Models\Achievement $achievement)
    {
        $user = Auth::user();

        $pivot = $user->achievements()
            ->where('achievement_id', $achievement->id)
            ->first();

        if (!$pivot) {
            return back()->with('error', 'Achievement not earned.');
        }

        $user->achievements()->updateExistingPivot($achievement->id, [
            'is_shared' => true,
            'shared_at' => now(),
        ]);

        \App\Models\CommunityPost::create([
            'user_id' => $user->id,
            'type' => 'achievement',
            'content' => "Earned: {$achievement->name}",
            'achievement_id' => $achievement->id,
            'metadata' => [
                'achievement_key' => $achievement->key,
                'achievement_name' => $achievement->name,
                'badge_color' => $achievement->badge_color,
                'icon' => $achievement->icon,
            ],
        ]);

        return back()->with('success', 'Achievement shared with the community!');
    }

    public function keepPrivate(\App\Models\Achievement $achievement)
    {
        $user = Auth::user();

        $user->achievements()->updateExistingPivot($achievement->id, [
            'is_shared' => false,
            'shared_at' => null,
        ]);

        return back()->with('success', 'Achievement kept private.');
    }
}
