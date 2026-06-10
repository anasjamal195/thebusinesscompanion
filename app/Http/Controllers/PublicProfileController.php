<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Auth;

class PublicProfileController extends Controller
{
    public function __construct(
        protected AchievementService $achievementService
    ) {}

    public function show(User $user)
    {
        $authUser = Auth::user();
        $isFollowing = false;

        if ($user->community_participation_mode === 'private' && $user->id !== Auth::id()) {
            if ($authUser) {
                $isFollowing = \App\Models\Follow::where('follower_id', $authUser->id)
                    ->where('following_id', $user->id)
                    ->where('status', 'accepted')
                    ->exists();
            }

            if (!$isFollowing) {
                $followersCount = $user->followers()->where('status', 'accepted')->count();
                $followingCount = $user->following()->where('status', 'accepted')->count();

                $achievements = collect();
                $allPosts = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
                $streak = 0;
                $tasksCompleted = 0;
                $reportsGenerated = 0;
                $callsAnswered = 0;
                $badgesEarned = 0;
                $sharedAchievements = 0;
                $totalPosts = 0;
                $mentorInfo = null;

                return view('profiles.public', compact(
                    'user', 'authUser', 'isFollowing', 'followersCount', 'followingCount',
                    'achievements', 'allPosts', 'streak', 'tasksCompleted',
                    'reportsGenerated', 'callsAnswered', 'badgesEarned',
                    'sharedAchievements', 'totalPosts', 'mentorInfo'
                ));
            }
        }

        $achievements = $user->achievements()
            ->withPivot(['earned_at', 'is_shared', 'shared_at'])
            ->get();

        $streak = $this->achievementService->calculateStreak($user);
        $tasksCompleted = $user->tasks()->where('status', 'completed')->count();
        $reportsGenerated = \App\Models\DailyReport::where('user_id', $user->id)->count();
        $callsAnswered = $user->calls()->where('status', 'completed')->count();
        $badgesEarned = $user->achievements()->count();
        $sharedAchievements = $user->achievements()
            ->wherePivot('is_shared', true)
            ->count();
        $totalPosts = \App\Models\CommunityPost::where('user_id', $user->id)->count();
        $mentorInfo = $user->mentor;

        $followersCount = $user->followers()->where('status', 'accepted')->count();
        $followingCount = $user->following()->where('status', 'accepted')->count();

        $allPosts = \App\Models\CommunityPost::with(['comments', 'likes'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        if ($authUser && $authUser->id !== $user->id) {
            $isFollowing = \App\Models\Follow::where('follower_id', $authUser->id)
                ->where('following_id', $user->id)
                ->where('status', 'accepted')
                ->exists();
        }

        return view('profiles.public', compact(
            'user', 'achievements', 'streak', 'tasksCompleted',
            'reportsGenerated', 'callsAnswered', 'badgesEarned',
            'sharedAchievements', 'followersCount', 'followingCount',
            'allPosts', 'authUser', 'isFollowing', 'mentorInfo', 'totalPosts'
        ));
    }
}
