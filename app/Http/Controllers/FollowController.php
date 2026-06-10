<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function followers()
    {
        $user = Auth::user();

        $acceptedFollowers = User::whereIn('id', function ($q) use ($user) {
            $q->select('follower_id')->from('follows')
              ->where('following_id', $user->id)
              ->where('status', 'accepted');
        })->paginate(20, ['*'], 'followers_page');

        $pendingFollowers = Follow::with('follower')
            ->where('following_id', $user->id)
            ->where('status', 'pending')
            ->get();

        $following = User::whereIn('id', function ($q) use ($user) {
            $q->select('following_id')->from('follows')
              ->where('follower_id', $user->id)
              ->where('status', 'accepted');
        })->paginate(20, ['*'], 'following_page');

        return view('follows.index', compact('acceptedFollowers', 'pendingFollowers', 'following'));
    }

    public function removeFollower(User $user)
    {
        $authUser = Auth::user();

        Follow::where('follower_id', $user->id)
            ->where('following_id', $authUser->id)
            ->delete();

        return back()->with('success', 'Follower removed.');
    }

    public function follow(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        $existing = Follow::where('follower_id', $authUser->id)
            ->where('following_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Unfollowed user.');
        }

        $isPrivate = $user->community_participation_mode === 'private';

        $follow = Follow::create([
            'follower_id' => $authUser->id,
            'following_id' => $user->id,
            'status' => $isPrivate ? 'pending' : 'accepted',
        ]);

        if ($isPrivate) {
            UserNotification::create([
                'user_id' => $user->id,
                'type' => 'follow_request',
                'title' => 'New Follow Request',
                'message' => $authUser->name . ' wants to follow you.',
                'data' => [
                    'follower_id' => $authUser->id,
                    'follow_id' => $follow->id,
                ],
            ]);

            return back()->with('success', 'Follow request sent!');
        }

        return back()->with('success', 'Now following user!');
    }

    public function acceptFollow(Follow $follow)
    {
        if ($follow->following_id !== Auth::id()) {
            abort(404);
        }

        $follow->update(['status' => 'accepted']);

        return back()->with('success', 'Follow request accepted.');
    }

    public function rejectFollow(Follow $follow)
    {
        if ($follow->following_id !== Auth::id()) {
            abort(404);
        }

        $follow->delete();

        return back()->with('success', 'Follow request rejected.');
    }
}
