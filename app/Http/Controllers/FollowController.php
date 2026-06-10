<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function followers()
    {
        $user = Auth::user();
        $followers = User::whereIn('id', function ($q) use ($user) {
            $q->select('follower_id')->from('follows')->where('following_id', $user->id);
        })->paginate(20);

        $following = User::whereIn('id', function ($q) use ($user) {
            $q->select('following_id')->from('follows')->where('follower_id', $user->id);
        })->paginate(20);

        return view('follows.index', compact('followers', 'following'));
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

        Follow::create([
            'follower_id' => $authUser->id,
            'following_id' => $user->id,
        ]);

        return back()->with('success', 'Now following user!');
    }
}
