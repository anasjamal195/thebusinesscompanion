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
        if ($user->community_participation_mode === 'private' && $user->id !== Auth::id()) {
            return back()->with('error', 'This user\'s profile is private.');
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

        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();

        $allPosts = \App\Models\CommunityPost::with(['comments', 'likes'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $authUser = Auth::user();
        $isFollowing = false;
        if ($authUser && $authUser->id !== $user->id) {
            $isFollowing = \App\Models\Follow::where('follower_id', $authUser->id)
                ->where('following_id', $user->id)
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
