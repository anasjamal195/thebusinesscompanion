<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\DailyReport;
use App\Models\Follow;
use App\Models\User;
use App\Services\AchievementService;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function __construct(
        protected AchievementService $achievementService
    ) {}

    public function show(Request $request, User $user)
    {
        $authUser = $request->user();
        $isFollowing = false;

        $followersCount = $user->followers()->where('status', 'accepted')->count();
        $followingCount = $user->following()->where('status', 'accepted')->count();

        if ($user->community_participation_mode === 'private' && $user->id !== $authUser->id) {
            $isFollowing = Follow::where('follower_id', $authUser->id)
                ->where('following_id', $user->id)
                ->where('status', 'accepted')
                ->exists();

            if (!$isFollowing) {
                return response()->json([
                    'user' => $user->only(['id', 'name', 'avatar']),
                    'community_participation_mode' => true,
                    'followers_count' => $followersCount,
                    'following_count' => $followingCount,
                    'is_following' => false,
                ]);
            }
        }

        $achievements = $user->achievements()
            ->withPivot(['earned_at', 'is_shared', 'shared_at'])
            ->get();

        $streak = $this->achievementService->calculateStreak($user);
        $tasksCompleted = $user->tasks()->where('status', 'completed')->count();
        $reportsGenerated = DailyReport::where('user_id', $user->id)->count();
        $callsAnswered = $user->calls()->where('status', 'completed')->count();
        $badgesEarned = $user->achievements()->count();
        $sharedAchievements = $user->achievements()
            ->wherePivot('is_shared', true)
            ->count();
        $totalPosts = CommunityPost::where('user_id', $user->id)->count();

        if ($authUser->id !== $user->id) {
            $isFollowing = Follow::where('follower_id', $authUser->id)
                ->where('following_id', $user->id)
                ->where('status', 'accepted')
                ->exists();
        }

        $allPosts = CommunityPost::withCount(['likes', 'comments'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $allPosts->getCollection()->transform(function ($post) use ($authUser) {
            $post->liked = $post->isLikedBy($authUser);
            return $post;
        });

        return response()->json([
            'user' => $user,
            'achievements' => $achievements,
            'stats' => [
                'streak' => $streak,
                'tasks_completed' => $tasksCompleted,
                'reports_generated' => $reportsGenerated,
                'calls_answered' => $callsAnswered,
                'badges_earned' => $badgesEarned,
                'shared_achievements' => $sharedAchievements,
                'total_posts' => $totalPosts,
                'followers_count' => $followersCount,
                'following_count' => $followingCount,
            ],
            'scores' => [
                'execution_score' => $user->execution_score,
                'community_reputation' => $user->community_reputation,
            ],
            'all_posts' => $allPosts,
            'is_following' => $isFollowing,
        ]);
    }
}
