<?php

namespace App\Services;

use App\Models\CommunityComment;
use App\Models\CommunityLike;
use App\Models\User;

class CommunityReputationService
{
    public function recalculate(User $user): int
    {
        $score = 0;

        $helpfulComments = CommunityComment::where('user_id', $user->id)->count();
        $score += min(30, $helpfulComments * 3);

        $likesReceived = CommunityLike::whereIn('post_id', function ($q) use ($user) {
            $q->select('id')->from('community_posts')->where('user_id', $user->id);
        })->count();
        $score += min(30, $likesReceived * 2);

        $followerCount = $user->followers()->count();
        $score += min(20, $followerCount);

        if ($user->mentor && $user->mentor->is_active) {
            $score += 20;
        }

        $score = min(100, max(0, $score));

        $user->update(['community_reputation' => $score]);

        return $score;
    }
}
