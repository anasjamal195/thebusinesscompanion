<?php

namespace App\Http\Controllers;

use App\Models\CommunityComment;
use App\Models\CommunityLike;
use App\Models\CommunityPost;
use App\Models\User;
use App\Services\CommunityReputationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function __construct(
        protected CommunityReputationService $reputationService
    ) {}

    public function feed()
    {
        $user = Auth::user();

        $followedIds = $user->following()->pluck('follows.following_id')->toArray();

        $posts = CommunityPost::with(['user', 'achievement', 'comments.user', 'likes'])
            ->whereIn('user_id', array_merge($followedIds, [$user->id]))
            ->orWhere(function ($q) {
                $q->whereHas('user', function ($uq) {
                    $uq->where('community_participation_mode', 'social');
                });
            })
            ->latest()
            ->paginate(20);

        $posts->loadCount('comments', 'likes');

        return view('community.feed', compact('posts', 'user'));
    }

    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:progress,success_story',
            'content' => 'required|string|max:5000',
        ]);

        $user = Auth::user();

        CommunityPost::create([
            'user_id' => $user->id,
            'type' => $validated['type'],
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Post shared with the community!');
    }

    public function like(CommunityPost $post)
    {
        $user = Auth::user();

        $existing = CommunityLike::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $this->reputationService->recalculate($post->user);

            return back()->with('success', 'Like removed.');
        }

        CommunityLike::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $this->reputationService->recalculate($post->user);

        return back()->with('success', 'Post liked!');
    }

    public function comment(Request $request, CommunityPost $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $user = Auth::user();

        CommunityComment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'content' => $validated['content'],
        ]);

        $this->reputationService->recalculate($post->user);

        return back()->with('success', 'Comment added!');
    }

    public function follow(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        $existing = \App\Models\Follow::where('follower_id', $authUser->id)
            ->where('following_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();

            return back()->with('success', 'Unfollowed user.');
        }

        \App\Models\Follow::create([
            'follower_id' => $authUser->id,
            'following_id' => $user->id,
        ]);

        $this->reputationService->recalculate($user);

        return back()->with('success', 'Now following user!');
    }
}
