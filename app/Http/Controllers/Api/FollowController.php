<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function followers(Request $request)
    {
        $user = $request->user();

        $acceptedFollowers = User::whereIn('id', function ($q) use ($user) {
            $q->select('follower_id')
                ->from('follows')
                ->where('following_id', $user->id)
                ->where('status', 'accepted');
        })->paginate(20, ['*'], 'accepted_page');

        $pendingFollowers = Follow::with('follower:id,name,avatar')
            ->where('following_id', $user->id)
            ->where('status', 'pending')
            ->get();

        $following = User::whereIn('id', function ($q) use ($user) {
            $q->select('following_id')
                ->from('follows')
                ->where('follower_id', $user->id)
                ->where('status', 'accepted');
        })->paginate(20, ['*'], 'following_page');

        return response()->json([
            'accepted_followers' => $acceptedFollowers,
            'pending_followers' => $pendingFollowers,
            'following' => $following,
        ]);
    }

    public function removeFollower(Request $request, User $user)
    {
        $authUser = $request->user();

        $deleted = Follow::where('follower_id', $user->id)
            ->where('following_id', $authUser->id)
            ->delete();

        if (!$deleted) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        return response()->json(['message' => 'Follower removed.']);
    }

    public function acceptFollow(Request $request, Follow $follow)
    {
        if ($follow->following_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($follow->status !== 'pending') {
            return response()->json(['message' => 'Follow request is not pending.'], 422);
        }

        $follow->update(['status' => 'accepted']);

        UserNotification::create([
            'user_id' => $follow->follower_id,
            'type' => 'follow_accepted',
            'title' => 'Follow Request Accepted',
            'message' => $request->user()->name . ' accepted your follow request.',
            'data' => ['following_id' => $request->user()->id],
        ]);

        $follow->load('follower:id,name,avatar');

        return response()->json(['follow' => $follow]);
    }

    public function rejectFollow(Request $request, Follow $follow)
    {
        if ($follow->following_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($follow->status !== 'pending') {
            return response()->json(['message' => 'Follow request is not pending.'], 422);
        }

        $follow->delete();

        return response()->json(['message' => 'Follow request rejected.']);
    }
}
