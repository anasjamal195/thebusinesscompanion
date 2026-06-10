@php
    $title = 'Feed';
    $pageTitle = 'Community Feed';
    $activeNav = 'feed';

    $postTypeMeta = [
        'progress' => ['label' => 'Progress', 'icon' => 'trending_up', 'color' => 'bg-blue-50 text-blue-700'],
        'success_story' => ['label' => 'Success Story', 'icon' => 'emoji_events', 'color' => 'bg-purple-50 text-purple-700'],
        'milestone' => ['label' => 'Milestone', 'icon' => 'flag', 'color' => 'bg-green-50 text-green-700'],
        'achievement' => ['label' => 'Achievement', 'icon' => 'stars', 'color' => 'bg-yellow-50 text-yellow-700'],
        'challenge_result' => ['label' => 'Challenge', 'icon' => 'flag', 'color' => 'bg-orange-50 text-orange-700'],
        'tip' => ['label' => 'Tip', 'icon' => 'lightbulb', 'color' => 'bg-teal-50 text-teal-700'],
        'question' => ['label' => 'Question', 'icon' => 'help', 'color' => 'bg-indigo-50 text-indigo-700'],
    ];
@endphp

@extends('layouts.app')

@section('content')
<div class="flex gap-6" x-data="{ showNewPost: false, commentPost: null, selectedType: 'progress' }">
    {{-- Left Sidebar --}}
    <div class="hidden lg:block w-56 shrink-0">
        <div class="sticky top-20 space-y-1">
            <a href="{{ route('community.feed') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-semibold bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-[20px]">dynamic_feed</span>
                Feed
            </a>
        </div>
    </div>

    {{-- Center Column --}}
    <div class="flex-1 min-w-0 max-w-2xl">
        <div class="space-y-4">
            {{-- New Post Button --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <button @click="showNewPost = !showNewPost; if(!showNewPost) selectedType='progress'" class="w-full flex items-center gap-3 px-4 py-3 text-left">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-semibold text-xs shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="flex-1 text-sm text-gray-400">Share your progress or story...</span>
                    <span class="material-symbols-outlined text-gray-400 text-[20px]" x-show="!showNewPost">add</span>
                    <span class="material-symbols-outlined text-gray-400 text-[20px]" x-show="showNewPost" x-cloak>close</span>
                </button>

                {{-- New Post Form --}}
                <div x-show="showNewPost" x-cloak class="border-t border-gray-100 px-4 py-4">
                    <form action="{{ route('community.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div class="flex items-center gap-2 flex-wrap">
                            @foreach($postTypeMeta as $typeKey => $typeMeta)
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="{{ $typeKey }}" x-model="selectedType" class="sr-only">
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
                                      :class="selectedType === '{{ $typeKey }}' ? '{{ $typeMeta['color'] }} ring-1 ring-inset' : 'bg-gray-100 text-gray-500 hover:bg-gray-200'">
                                    <span class="material-symbols-outlined text-[14px]">{{ $typeMeta['icon'] }}</span>
                                    {{ $typeMeta['label'] }}
                                </span>
                            </label>
                            @endforeach
                        </div>

                        <div>
                            <textarea name="content" rows="4" required maxlength="5000" class="w-full rounded-lg border-gray-200 bg-gray-50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm resize-none" placeholder="What's on your mind?"></textarea>
                        </div>

                        {{-- Achievement selector --}}
                        <template x-if="selectedType === 'achievement'">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Select Achievement</label>
                                <select name="achievement_id" class="w-full rounded-lg border-gray-200 bg-gray-50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                                    <option value="">Choose...</option>
                                    @foreach($userAchievements as $ach)
                                        <option value="{{ $ach->id }}">{{ $ach->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </template>

                        {{-- Image upload --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Add Image (optional)</label>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp" class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors">
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-xs text-gray-400">Share your journey with the community</p>
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">send</span>
                                Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Feed --}}
            <div class="space-y-4">
                @forelse ($posts as $post)
                    @php
                        $pt = $postTypeMeta[$post->type] ?? ['label' => ucfirst($post->type), 'icon' => 'article', 'color' => 'bg-gray-50 text-gray-700'];
                    @endphp
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                        {{-- Post Header --}}
                        <div class="flex items-center justify-between px-4 pt-4 pb-2">
                            <a href="{{ route('profiles.public', $post->user) }}" class="flex items-center gap-2.5 group">
                                <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-semibold text-sm">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 group-hover:text-primary transition-colors">{{ $post->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                            <span class="inline-flex items-center gap-0.5 text-[11px] font-medium px-2 py-0.5 rounded-md {{ $pt['color'] }}">
                                <span class="material-symbols-outlined text-[14px]">{{ $pt['icon'] }}</span>
                                {{ $pt['label'] }}
                            </span>
                        </div>

                        {{-- Visibility Badge --}}
                        @if($post->visibility && $post->visibility !== 'public')
                            <div class="px-4 pb-1">
                                <span class="inline-flex items-center gap-0.5 text-[10px] font-medium text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-[12px]">people</span>
                                    Followers only
                                </span>
                            </div>
                        @endif

                        {{-- Report metadata badge --}}
                        @if($post->daily_report_id && $post->metadata)
                            <div class="px-4 pb-1">
                                <span class="inline-flex items-center gap-0.5 text-[10px] font-medium text-primary bg-primary/5 px-1.5 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-[12px]">summarize</span>
                                    Daily Report &middot; {{ $post->metadata['completed'] ?? 0 }}/{{ $post->metadata['total'] ?? 0 }} tasks
                                </span>
                            </div>
                        @endif

                        {{-- Achievement Badge --}}
                        @if($post->achievement)
                            <div class="px-4 mb-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-lg" style="background: {{ $post->achievement->badge_color }}12; color: {{ $post->achievement->badge_color }}">
                                <span class="material-symbols-outlined text-[16px]">{{ $post->achievement->icon }}</span>
                                <span class="text-xs font-medium">{{ $post->achievement->name }}</span>
                            </div>
                        @endif

                        {{-- Post Content --}}
                        <div class="px-4 py-2">
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $post->content }}</p>
                        </div>

                        {{-- Post Image --}}
                        @if($post->image)
                            <div class="px-4 pb-2">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="rounded-lg w-full max-h-96 object-cover border border-gray-100" loading="lazy">
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="flex items-center gap-1 px-4 py-2.5 border-t border-gray-50">
                            <form action="{{ route('community.like', $post) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $post->isLikedBy($user) ? 'text-red-500 bg-red-50' : 'text-gray-400 hover:text-red-500 hover:bg-red-50' }}">
                                    <span class="material-symbols-outlined text-[18px]">{{ $post->isLikedBy($user) ? 'favorite' : 'favorite_border' }}</span>
                                    {{ $post->likes_count ?? $post->likes->count() }}
                                </button>
                            </form>

                            <button @click="commentPost = commentPost === {{ $post->id }} ? null : {{ $post->id }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-gray-400 hover:text-primary hover:bg-blue-50 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">comment</span>
                                {{ $post->comments_count ?? $post->comments->count() }}
                            </button>

                            @if(Auth::user()->id !== $post->user_id)
                                <form action="{{ route('community.follow', $post->user) }}" method="POST" class="inline ml-auto">
                                    @csrf
                                    <button type="submit" class="text-xs font-medium text-primary hover:text-primary-container transition-colors flex items-center gap-1 px-2 py-1 rounded hover:bg-blue-50">
                                        <span class="material-symbols-outlined text-[14px]">person_add</span>
                                        {{ $user->following()->where('following_id', $post->user->id)->exists() ? 'Following' : 'Follow' }}
                                    </button>
                                </form>
                            @endif
                        </div>

                        {{-- Comments Section --}}
                        <div x-show="commentPost === {{ $post->id }}" x-cloak class="border-t border-gray-100 px-4 py-4 space-y-3">
                            @foreach ($post->comments as $comment)
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-md bg-gray-100 text-gray-500 flex items-center justify-center font-semibold text-xs shrink-0 mt-0.5">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="bg-gray-50 rounded-lg px-3 py-2">
                                            <p class="text-xs font-medium text-gray-900">{{ $comment->user->name }}</p>
                                            <p class="text-sm text-gray-600 mt-0.5">{{ $comment->content }}</p>
                                        </div>
                                        <p class="text-[11px] text-gray-400 mt-0.5">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach

                            <form action="{{ route('community.comment', $post) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <input type="text" name="content" required maxlength="2000" placeholder="Write a comment..." class="flex-1 rounded-lg border-gray-200 bg-gray-50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                                <button type="submit" class="px-3 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">send</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm text-center py-12">
                        <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">dynamic_feed</span>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">No posts yet</h3>
                        <p class="text-sm text-gray-500">Be the first to share your progress!</p>
                    </div>
                @endforelse

                <div class="py-4">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Right Sidebar --}}
    <div class="hidden xl:block w-72 shrink-0">
        <div class="sticky top-20 space-y-5">
            @auth
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-4 py-3 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Quick Links</h3>
                </div>
                <div class="p-3 space-y-1">
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-2.5 px-2 py-2 rounded-lg text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-primary">person</span>
                        My Profile
                    </a>
                    <a href="{{ route('calendar.index') }}" class="flex items-center gap-2.5 px-2 py-2 rounded-lg text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-primary">calendar_month</span>
                        Calendar
                    </a>
                    <a href="{{ route('calls.index') }}" class="flex items-center gap-2.5 px-2 py-2 rounded-lg text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-green-500">call_log</span>
                        Call History
                    </a>
                    <a href="{{ route('reports.index') }}" class="flex items-center gap-2.5 px-2 py-2 rounded-lg text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-primary">summarize</span>
                        Reports
                    </a>
                </div>
            </div>
            @endauth

            <div class="text-xs text-gray-400 px-1 space-y-1">
                <p>Be respectful and supportive. Share your journey and help others grow.</p>
            </div>
        </div>
    </div>
</div>
@endsection
