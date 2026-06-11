<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\CommunityComment;
use App\Models\CommunityLike;
use App\Models\Follow;
use App\Models\User;
use App\Models\UserNotification;
use App\Services\CommunityReputationService;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function feed(Request $request)
    {
        $user = $request->user();
        $followingIds = Follow::where('follower_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('following_id')
            ->push($user->id);

        $posts = CommunityPost::with([
            'user:id,name,avatar,community_reputation,execution_score',
            'achievement',
            'comments.user:id,name,avatar',
            'comments' => fn($q) => $q->latest()->take(3),
        ])
            ->withCount(['likes', 'comments'])
            ->where(function ($q) use ($followingIds, $user) {
                $q->where('visibility', 'public')
                    ->orWhere(function ($q) use ($followingIds) {
                        $q->where('visibility', 'followers')
                            ->whereIn('user_id', $followingIds);
                    })
                    ->orWhere('user_id', $user->id);
            })
            ->latest()
            ->paginate(20);

        $posts->getCollection()->transform(function ($post) use ($user) {
            $post->auth_user_id = $user->id;
            $post->liked = $post->isLikedBy($user);
            return $post;
        });

        $topFollowers = User::whereIn('id', function ($q) use ($user) {
            $q->select('follower_id')
                ->from('follows')
                ->where('following_id', $user->id)
                ->where('status', 'accepted');
        })
            ->withCount(['followers' => fn($q) => $q->where('status', 'accepted')])
            ->orderByDesc('followers_count')
            ->limit(5)
            ->get(['id', 'name', 'avatar']);

        return response()->json([
            'posts' => $posts,
            'top_followers' => $topFollowers,
        ]);
    }

    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'content' => 'required|string|max:5000',
            'achievement_id' => 'nullable|exists:achievements,id',
            'image' => 'nullable|string|max:2048',
        ]);

        $post = CommunityPost::create([
            'user_id' => $request->user()->id,
            'type' => $validated['type'],
            'content' => $validated['content'],
            'achievement_id' => $validated['achievement_id'] ?? null,
            'image' => $validated['image'] ?? null,
        ]);

        $post->load(['user:id,name,avatar', 'achievement']);

        return response()->json(['post' => $post], 201);
    }

    public function likePost(Request $request, CommunityPost $post, CommunityReputationService $reputationService)
    {
        $user = $request->user();
        $existing = CommunityLike::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            CommunityLike::create([
                'post_id' => $post->id,
                'user_id' => $user->id,
            ]);
            $liked = true;
        }

        $likesCount = $post->likes()->count();

        $reputationService->recalculate($post->user);

        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount,
        ]);
    }

    public function comment(Request $request, CommunityPost $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = CommunityComment::create([
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
            'content' => $validated['content'],
        ]);

        $comment->load('user:id,name,avatar');

        $commentsCount = $post->comments()->count();

        return response()->json([
            'comment' => $comment,
            'comments_count' => $commentsCount,
        ], 201);
    }

    public function updatePost(Request $request, CommunityPost $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $post->update(['content' => $validated['content']]);

        $post->load(['user:id,name,avatar', 'achievement']);

        return response()->json(['post' => $post]);
    }

    public function destroyPost(Request $request, CommunityPost $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted.']);
    }

    public function follow(Request $request, User $user)
    {
        $authUser = $request->user();

        if ($authUser->id === $user->id) {
            return response()->json(['message' => 'Cannot follow yourself.'], 422);
        }

        $existing = Follow::where('follower_id', $authUser->id)
            ->where('following_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $following = false;
        } else {
            $status = $user->community_participation_mode === 'private' ? 'pending' : 'accepted';
            Follow::create([
                'follower_id' => $authUser->id,
                'following_id' => $user->id,
                'status' => $status,
            ]);
            $following = true;

            if ($status === 'pending') {
                UserNotification::create([
                    'user_id' => $user->id,
                    'type' => 'follow_request',
                    'title' => 'New Follow Request',
                    'message' => "{$authUser->name} wants to follow you.",
                    'data' => ['follower_id' => $authUser->id],
                ]);
            }
        }

        return response()->json(['following' => $following]);
    }
}
