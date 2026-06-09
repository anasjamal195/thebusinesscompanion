@php
    $title = 'Community';
    $pageTitle = 'Community Feed';
    $activeNav = 'community';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700 max-w-4xl mx-auto" x-data="{ showNewPost: false, commentPost: null, commentText: '' }">
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Community</h2>
        @if(session('success'))
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-xl text-sm font-bold border border-green-100">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- New Post Button -->
    <button @click="showNewPost = !showNewPost" class="w-full bg-white rounded-[2rem] p-6 shadow-lg shadow-gray-200/30 border border-gray-50 hover:border-primary/20 transition-all flex items-center gap-4 text-left">
        <span class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[28px]">edit_note</span>
        </span>
        <div>
            <p class="font-bold text-gray-900">Share your progress</p>
            <p class="text-sm text-gray-500">Post a progress update or success story</p>
        </div>
        <span class="ml-auto material-symbols-outlined text-gray-400" x-show="!showNewPost">add</span>
        <span class="ml-auto material-symbols-outlined text-gray-400" x-show="showNewPost" x-cloak>close</span>
    </button>

    <!-- New Post Form -->
    <div x-show="showNewPost" x-cloak class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
        <form action="{{ route('community.posts.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Post Type</label>
                <select name="type" class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-primary focus:ring focus:ring-primary/20 font-semibold">
                    <option value="progress">Progress Update</option>
                    <option value="success_story">Success Story</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Content</label>
                <textarea name="content" rows="4" required maxlength="5000" class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-primary focus:ring focus:ring-primary/20 font-semibold resize-none" placeholder="Share your journey..."></textarea>
            </div>
            <button type="submit" class="px-8 py-3 bg-primary hover:bg-primary-container text-white font-bold rounded-2xl shadow-lg shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">send</span>
                Post
            </button>
        </form>
    </div>

    <!-- Feed -->
    <div class="space-y-6">
        @forelse ($posts as $post)
            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
                <!-- Post Header -->
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('profiles.public', $post->user) }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                            {{ substr($post->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 group-hover:text-primary transition-colors text-sm">{{ $post->user->name }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                    <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full {{ $post->type === 'achievement' ? 'bg-yellow-100 text-yellow-700' : ($post->type === 'success_story' ? 'bg-purple-100 text-purple-700' : ($post->type === 'challenge_result' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700')) }}">
                        @switch($post->type)
                            @case('achievement') Achievement @break
                            @case('progress') Progress @break
                            @case('success_story') Success Story @break
                            @case('challenge_result') Challenge @break
                        @endswitch
                    </span>
                </div>

                <!-- Achievement Badge Display -->
                @if($post->achievement)
                    <div class="mb-4 inline-flex items-center gap-2 px-4 py-2 rounded-2xl" style="background: {{ $post->achievement->badge_color }}15; color: {{ $post->achievement->badge_color }}">
                        <span class="material-symbols-outlined text-[20px]">{{ $post->achievement->icon }}</span>
                        <span class="font-bold text-sm">{{ $post->achievement->name }}</span>
                    </div>
                @endif

                <!-- Post Content -->
                <div class="text-gray-700 font-medium leading-relaxed whitespace-pre-wrap">{{ $post->content }}</div>

                <!-- Actions -->
                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center gap-6">
                    <form action="{{ route('community.like', $post) }}" method="POST" class="inline">
                        @csrf
                            <button type="submit" class="flex items-center gap-1.5 text-sm font-bold transition-colors {{ $post->isLikedBy($user) ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}">
                            <span class="material-symbols-outlined text-[20px]">                                {{ $post->isLikedBy($user) ? 'favorite' : 'favorite_border' }}</span>
                            {{ $post->likes_count ?? $post->likes->count() }}
                        </button>
                    </form>

                    <button @click="commentPost = commentPost === {{ $post->id }} ? null : {{ $post->id }}" class="flex items-center gap-1.5 text-sm font-bold text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">comment</span>
                        {{ $post->comments_count ?? $post->comments->count() }}
                    </button>

                    @if(Auth::user()->id !== $post->user_id)
                        <form action="{{ route('community.follow', $post->user) }}" method="POST" class="inline ml-auto">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-primary hover:text-primary-container transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">person_add</span>
                                {{ $user->following()->where('following_id', $post->user->id)->exists() ? 'Following' : 'Follow' }}
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Comments Section -->
                <div x-show="commentPost === {{ $post->id }}" x-cloak class="mt-6 pt-4 border-t border-gray-100 space-y-4">
                    @foreach ($post->comments as $comment)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-gray-100 text-gray-500 flex items-center justify-center font-bold text-xs shrink-0">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-gray-50 rounded-2xl px-4 py-3">
                                    <p class="font-bold text-xs text-gray-900">{{ $comment->user->name }}</p>
                                    <p class="text-sm text-gray-600 font-medium mt-0.5">{{ $comment->content }}</p>
                                </div>
                                <p class="text-[10px] text-gray-400 font-medium mt-1 px-1">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach

                    <form action="{{ route('community.comment', $post) }}" method="POST" class="flex items-center gap-3">
                        @csrf
                        <input type="text" name="content" required maxlength="2000" placeholder="Write a comment..." class="flex-1 rounded-2xl border-gray-200 bg-gray-50 focus:border-primary focus:ring focus:ring-primary/20 font-medium text-sm">
                        <button type="submit" class="px-5 py-3 bg-primary text-white font-bold rounded-2xl text-sm hover:bg-primary-container transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[18px]">send</span>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-16">
                <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">groups</span>
                <h3 class="text-xl font-black text-gray-900 mb-2">No posts yet</h3>
                <p class="text-gray-500 font-medium">Be the first to share your progress with the community!</p>
            </div>
        @endforelse

        {{ $posts->links() }}
    </div>
</div>
@endsection
