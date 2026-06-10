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
<div class="flex gap-6" x-data="feedComponent()">
    {{-- Left Sidebar --}}
    <div class="hidden lg:block w-56 shrink-0">
        <div class="sticky top-20 space-y-5">
            <div class="space-y-1">
                <a href="{{ route('community.feed') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-semibold bg-primary/10 text-primary">
                    <span class="material-symbols-outlined text-[20px]">dynamic_feed</span>
                    Feed
                </a>
            </div>

            @auth
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-4 py-3 border-b border-gray-100">
                    <h3 class="text-xs font-semibold text-gray-900">My Followers</h3>
                </div>
                <div class="p-2 space-y-0.5">
                    @forelse ($topFollowers as $follow)
                        @php $follower = $follow->follower; @endphp
                        <a href="{{ route('profiles.public', $follower) }}" class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-gray-50 transition-colors group">
                            <div class="w-7 h-7 rounded-md bg-primary/10 text-primary flex items-center justify-center font-semibold text-xs shrink-0">
                                {{ substr($follower->name, 0, 1) }}
                            </div>
                            <span class="text-xs font-medium text-gray-600 group-hover:text-primary truncate">{{ $follower->name }}</span>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 px-2 py-2">No followers yet.</p>
                    @endforelse
                </div>
                <div class="px-3 py-2 border-t border-gray-100">
                    <a href="{{ route('followers.index') }}" class="flex items-center justify-center gap-1.5 text-xs font-medium text-primary hover:text-primary-container transition-colors">
                        <span class="material-symbols-outlined text-[14px]">manage_accounts</span>
                        Manage Followers
                    </a>
                </div>
            </div>
            @endauth
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
                            <div>
                            @if(Auth::user()->id === $post->user_id)
                                <div class="flex items-center gap-1">
                                    <button @click="openEdit({{ $post->id }}, $el)" data-content="{{ $post->content }}" class="text-xs text-gray-400 hover:text-primary p-1 rounded hover:bg-gray-50 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </button>
                                    <button @click="confirmDelete = {{ $post->id }}; deleteTarget = 'post'" class="text-xs text-gray-400 hover:text-red-500 p-1 rounded hover:bg-red-50 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                    </button>
                                </div>
                            @endif
                            <span class="inline-flex items-center gap-0.5 text-[11px] font-medium px-2 py-0.5 rounded-md {{ $pt['color'] }}">
                                <span class="material-symbols-outlined text-[14px]">{{ $pt['icon'] }}</span>
                                {{ $pt['label'] }}
                            </span>
                            </div>
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

                        {{-- Achievement Badge --}}
                        @if($post->achievement)
                            <div class="mx-4 mb-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-lg" style="background: {{ $post->achievement->badge_color }}12; color: {{ $post->achievement->badge_color }}">
                                <span class="material-symbols-outlined text-[16px]">{{ $post->achievement->icon }}</span>
                                <span class="text-xs font-medium">{{ $post->achievement->name }}</span>
                            </div>
                        @endif

                        {{-- Post Content --}}
                        <div class="px-4 py-2">
                            {{-- Edit mode --}}
                            @if(Auth::user()->id === $post->user_id)
                                <div x-show="editPostId === {{ $post->id }}" x-cloak class="space-y-2">
                                    <textarea x-model="editContent" class="w-full rounded-lg border-gray-200 bg-gray-50 text-sm" rows="3"></textarea>
                                    <div class="flex gap-2">
                                        <button @click="saveEdit({{ $post->id }})" class="px-3 py-1.5 rounded-lg bg-primary text-white text-xs font-semibold flex items-center gap-1" :disabled="loading.edit === {{ $post->id }}">
                                            <span x-show="loading.edit === {{ $post->id }}" class="material-symbols-outlined text-[14px] animate-spin">progress_activity</span>
                                            <span x-show="loading.edit !== {{ $post->id }}">Save</span>
                                        </button>
                                        <button @click="cancelEdit()" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600">Cancel</button>
                                    </div>
                                </div>
                            @endif

                            <div x-show="editPostId !== {{ $post->id }}">
                                @if($post->type === 'progress' && $post->metadata)
                                    @php
                                        $pct = min(100, max(0, $post->metadata['score'] ?? 0));
                                        if ($pct >= 80) {
                                            $theme = ['card' => 'from-green-50 to-emerald-50', 'border' => 'border-green-200', 'text' => 'text-green-600', 'bar' => 'bg-green-500', 'icon' => 'check_circle'];
                                        } elseif ($pct >= 50) {
                                            $theme = ['card' => 'from-amber-50 to-yellow-50', 'border' => 'border-amber-200', 'text' => 'text-amber-600', 'bar' => 'bg-yellow-500', 'icon' => 'trending_up'];
                                        } else {
                                            $theme = ['card' => 'from-red-50 to-rose-50', 'border' => 'border-red-200', 'text' => 'text-red-600', 'bar' => 'bg-red-500', 'icon' => 'fiber_manual_record'];
                                        }
                                    @endphp
                                    {{-- Infographic Layout for Progress Posts --}}
                                    <p class="text-sm text-gray-800 leading-relaxed mb-4">{{ $post->content }}</p>
                                    <div class="bg-gradient-to-br {{ $theme['card'] }} rounded-xl border {{ $theme['border'] }} p-4 space-y-4">
                                        {{-- Stats Row --}}
                                        <div class="grid grid-cols-3 gap-3">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold {{ $theme['text'] }}">{{ $post->metadata['completed'] ?? 0 }}</div>
                                                <div class="text-[10px] font-medium uppercase tracking-wider text-gray-400">Done</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-gray-700">{{ $post->metadata['total'] ?? 0 }}</div>
                                                <div class="text-[10px] font-medium uppercase tracking-wider text-gray-400">Total</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold {{ $theme['text'] }}">
                                                    {{ $pct }}%
                                                </div>
                                                <div class="text-[10px] font-medium uppercase tracking-wider text-gray-400">Score</div>
                                            </div>
                                        </div>

                                        {{-- Progress Bar --}}
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="h-2.5 rounded-full transition-all duration-500 {{ $theme['bar'] }}" style="width: {{ $pct }}%"></div>
                                        </div>

                                        {{-- AI Summary --}}
                                        @if($post->metadata['ai_summary'] ?? null)
                                            <div class="flex items-start gap-2 text-xs text-gray-600 bg-white/60 rounded-lg p-3">
                                                <span class="material-symbols-outlined text-[16px] {{ $theme['text'] }} shrink-0 mt-0.5">auto_awesome</span>
                                                <span>{{ $post->metadata['ai_summary'] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $post->content }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Post Image --}}
                        @if($post->image)
                            <div class="px-4 pb-2">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="rounded-lg w-full max-h-96 object-cover border border-gray-100" loading="lazy">
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="flex items-center gap-1 px-4 py-2.5 border-t border-gray-50">
                            <button @click.prevent="toggleLike({{ $post->id }}, $el)"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $post->isLikedBy($user) ? 'text-red-500 bg-red-50' : 'text-gray-400 hover:text-red-500 hover:bg-red-50' }}" :disabled="loading.like === {{ $post->id }}">
                                <span x-show="loading.like === {{ $post->id }}" class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span>
                                <span x-show="loading.like !== {{ $post->id }}" class="material-symbols-outlined text-[18px] like-icon">{{ $post->isLikedBy($user) ? 'favorite' : 'favorite_border' }}</span>
                                <span class="like-count">{{ $post->likes_count ?? $post->likes->count() }}</span>
                            </button>

                            <button @click="commentPost = commentPost === {{ $post->id }} ? null : {{ $post->id }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-gray-400 hover:text-primary hover:bg-blue-50 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">comment</span>
                                <span data-comment-count="{{ $post->id }}">{{ $post->comments_count ?? $post->comments->count() }}</span>
                            </button>

                            @if(Auth::user()->id !== $post->user_id)
                                <button @click.prevent="toggleFollow({{ $post->user->id }}, $el)"
                                    class="text-xs font-medium text-primary hover:text-primary-container transition-colors flex items-center gap-1 px-2 py-1 rounded hover:bg-blue-50 ml-auto" :disabled="loading.follow === {{ $post->user->id }}">
                                    <span x-show="loading.follow === {{ $post->user->id }}" class="material-symbols-outlined text-[14px] animate-spin">progress_activity</span>
                                    <span x-show="loading.follow !== {{ $post->user->id }}" class="material-symbols-outlined text-[14px]">{{ $user->following()->where('following_id', $post->user->id)->exists() ? 'check' : 'person_add' }}</span>
                                    <span class="follow-text">{{ $user->following()->where('following_id', $post->user->id)->exists() ? 'Following' : 'Follow' }}</span>
                                </button>
                            @endif
                        </div>

                        {{-- Comments Section --}}
                        <div x-show="commentPost === {{ $post->id }}" x-cloak class="border-t border-gray-100 px-4 py-4 space-y-3" data-comments-section="{{ $post->id }}">
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

                            <form @submit.prevent="submitComment({{ $post->id }})" class="flex items-center gap-2">
                                @csrf
                                <input type="text" name="content" required maxlength="2000" placeholder="Write a comment..." data-comment-input="{{ $post->id }}" class="flex-1 rounded-lg border-gray-200 bg-gray-50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                                <button type="submit" class="px-3 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm flex items-center gap-1" :disabled="loading.comment === {{ $post->id }}">
                                    <span x-show="loading.comment === {{ $post->id }}" class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span>
                                    <span x-show="loading.comment !== {{ $post->id }}" class="material-symbols-outlined text-[18px]">send</span>
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

{{-- Delete Confirmation Modal --}}
<div x-show="confirmDelete" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-black/20 backdrop-blur-sm" @click.away="confirmDelete = null">
    <div class="bg-white rounded-xl shadow-xl max-w-sm w-full p-6 space-y-4" @click.stop>
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px]">delete</span>
            </span>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Delete <span x-text="deleteTarget === 'post' ? 'Post' : ''"></span>?</h3>
                <p class="text-sm text-gray-500">This action cannot be undone.</p>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button @click="confirmDelete = null" class="flex-1 px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                Cancel
            </button>
            <button @click="confirmDeleteAction()" class="flex-1 px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition-all shadow-sm flex items-center justify-center gap-1" :disabled="loading.delete">
                <span x-show="loading.delete" class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span>
                <span x-show="!loading.delete">Delete</span>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', function () {
    Alpine.data('feedComponent', function () {
        return {
            showNewPost: false,
            commentPost: null,
            selectedType: 'progress',
            editPostId: null,
            editContent: '',
            confirmDelete: null,
            deleteTarget: null,
            loading: {
                like: null,
                comment: null,
                edit: null,
                delete: null,
                follow: null,
            },
            userName: @json(Auth::user()->name),
            userInitial: @json(substr(Auth::user()->name, 0, 1)),
            escapeHtml(str) {
                const el = document.createElement('span');
                el.textContent = str;
                return el.innerHTML;
            },
            async toggleLike(postId, btn) {
                this.loading.like = postId;
                try {
                    const res = await fetch(`/community/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    });
                    if (!res.ok) return;
                    const data = await res.json();
                    const icon = btn.querySelector('.like-icon');
                    const count = btn.querySelector('.like-count');
                    if (icon) icon.textContent = data.liked ? 'favorite' : 'favorite_border';
                    if (count) count.textContent = data.likes_count;
                    btn.classList.toggle('text-red-500', data.liked);
                    btn.classList.toggle('bg-red-50', data.liked);
                    btn.classList.toggle('text-gray-400', !data.liked);
                    btn.classList.toggle('hover:text-red-500', !data.liked);
                    btn.classList.toggle('hover:bg-red-50', !data.liked);
                } finally {
                    this.loading.like = null;
                }
            },
            async submitComment(postId) {
                const input = document.querySelector(`[data-comment-input="${postId}"]`);
                if (!input || !input.value.trim()) return;
                this.loading.comment = postId;
                try {
                    const content = input.value.trim();
                    const res = await fetch(`/community/${postId}/comment`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ content }),
                    });
                    if (!res.ok) return;
                    const data = await res.json();
                    input.value = '';
                    const section = document.querySelector(`[data-comments-section="${postId}"]`);
                    if (section && data.comment) {
                        const div = document.createElement('div');
                        div.className = 'flex items-start gap-2.5';
                        div.innerHTML = `<div class='w-7 h-7 rounded-md bg-gray-100 text-gray-500 flex items-center justify-center font-semibold text-xs shrink-0 mt-0.5'>${this.userInitial}</div><div class='flex-1 min-w-0'><div class='bg-gray-50 rounded-lg px-3 py-2'><p class='text-xs font-medium text-gray-900'>${this.escapeHtml(this.userName)}</p><p class='text-sm text-gray-600 mt-0.5'>${this.escapeHtml(data.comment.content)}</p></div><p class='text-[11px] text-gray-400 mt-0.5'>${data.comment.created_at}</p></div>`;
                        section.insertBefore(div, section.lastElementChild);
                    }
                    const countEl = document.querySelector(`[data-comment-count="${postId}"]`);
                    if (countEl) countEl.textContent = data.comments_count;
                } finally {
                    this.loading.comment = null;
                }
            },
            openEdit(postId, btn) {
                this.editPostId = postId;
                this.editContent = btn.getAttribute('data-content') || '';
            },
            cancelEdit() {
                this.editPostId = null;
                this.editContent = '';
            },
            async saveEdit(postId) {
                if (!this.editContent.trim()) return;
                this.loading.edit = postId;
                try {
                    const res = await fetch(`/community/${postId}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ content: this.editContent }),
                    });
                    if (res.ok) {
                        this.editPostId = null;
                        location.reload();
                    }
                } finally {
                    this.loading.edit = null;
                }
            },
            async confirmDeleteAction() {
                if (!this.confirmDelete) return;
                this.loading.delete = this.confirmDelete;
                try {
                    const res = await fetch(`/community/${this.confirmDelete}/delete`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    });
                    const postId = this.confirmDelete;
                    this.confirmDelete = null;
                    this.deleteTarget = null;
                    if (res.ok) location.reload();
                } finally {
                    this.loading.delete = null;
                }
            },
            async toggleFollow(userId, btn) {
                this.loading.follow = userId;
                try {
                    const res = await fetch(`/community/follow/${userId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    });
                    if (!res.ok) return;
                    const data = await res.json();
                    const icon = btn.querySelector('.material-symbols-outlined');
                    const text = btn.querySelector('.follow-text');
                    if (data.following) {
                        icon.textContent = 'check';
                        text.textContent = 'Following';
                    } else {
                        icon.textContent = 'person_add';
                        text.textContent = 'Follow';
                    }
                } finally {
                    this.loading.follow = null;
                }
            },
        };
    });
});
</script>
@endsection
