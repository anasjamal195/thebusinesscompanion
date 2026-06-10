<?php

namespace App\Http\Controllers;

use App\Models\CommunityComment;
use App\Models\CommunityLike;
use App\Models\CommunityPost;
use App\Models\User;
use App\Services\CommunityReputationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            ->where(function ($q) use ($user, $followedIds) {
                $q->whereNull('visibility')
                  ->orWhere('visibility', 'public')
                  ->orWhere('user_id', $user->id)
                  ->orWhereIn('user_id', $followedIds);
            })
            ->latest()
            ->paginate(20);

        $posts->loadCount('comments', 'likes');

        $userAchievements = $user->achievements()->get();

        $topFollowers = $user->followers()->with('follower')->take(10)->get();

        return view('community.feed', compact('posts', 'user', 'userAchievements', 'topFollowers'));
    }

    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:progress,success_story,milestone,achievement,challenge_result,tip,question',
            'content' => 'required|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'achievement_id' => 'nullable|exists:achievements,id',
        ]);

        $user = Auth::user();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('community-images', 'public');
        }

        CommunityPost::create([
            'user_id' => $user->id,
            'type' => $validated['type'],
            'content' => $validated['content'],
            'image' => $imagePath,
            'achievement_id' => $validated['achievement_id'] ?? null,
            'visibility' => 'public',
            'metadata' => $request->input('metadata', []),
        ]);

        return back()->with('success', 'Post shared with the community!');
    }

    public function like(Request $request, CommunityPost $post)
    {
        $user = Auth::user();

        $existing = CommunityLike::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $this->reputationService->recalculate($post->user);

            if ($request->wantsJson()) {
                return response()->json(['liked' => false, 'likes_count' => $post->likes()->count()]);
            }
            return back()->with('success', 'Like removed.');
        }

        CommunityLike::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $this->reputationService->recalculate($post->user);

        if ($request->wantsJson()) {
            return response()->json(['liked' => true, 'likes_count' => $post->likes()->count()]);
        }
        return back()->with('success', 'Post liked!');
    }

    public function comment(Request $request, CommunityPost $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $user = Auth::user();

        $comment = CommunityComment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'content' => $validated['content'],
        ]);

        $this->reputationService->recalculate($post->user);

        if ($request->wantsJson()) {
            $comment->load('user');
            return response()->json([
                'comment' => [
                    'id' => $comment->id,
                    'content' => e($comment->content),
                    'user' => ['name' => e($comment->user->name)],
                    'created_at' => $comment->created_at->diffForHumans(),
                ],
                'comments_count' => $post->comments()->count(),
            ]);
        }
        return back()->with('success', 'Comment added!');
    }

    public function updatePost(Request $request, CommunityPost $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(404);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $post->update(['content' => $validated['content']]);

        return back()->with('success', 'Post updated.');
    }

    public function destroyPost(CommunityPost $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(404);
        }

        $post->delete();

        return back()->with('success', 'Post deleted.');
    }

    public function follow(Request $request, User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id === $user->id) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'You cannot follow yourself.'], 422);
            }
            return back()->with('error', 'You cannot follow yourself.');
        }

        $existing = \App\Models\Follow::where('follower_id', $authUser->id)
            ->where('following_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();

            if ($request->wantsJson()) {
                return response()->json(['following' => false]);
            }
            return back()->with('success', 'Unfollowed user.');
        }

        \App\Models\Follow::create([
            'follower_id' => $authUser->id,
            'following_id' => $user->id,
        ]);

        $this->reputationService->recalculate($user);

        if ($request->wantsJson()) {
            return response()->json(['following' => true]);
        }
        return back()->with('success', 'Now following user!');
    }
}
