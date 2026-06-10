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
                    <x-community-post
                        :post="$post"
                        :postTypeMeta="$postTypeMeta"
                        :user="$user"
                        :showActions="true"
                        :showFollow="true"
                        :interactive="true"
                    />
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
                <h3 class="text-base font-semibold text-gray-900">Delete Post?</h3>
                <p class="text-sm text-gray-500">This action cannot be undone.</p>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button @click="confirmDelete = null" class="flex-1 px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                Cancel
            </button>
            <form x-bind:action="`/community/${confirmDelete}/delete`" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition-all shadow-sm">
                    Delete
                </button>
            </form>
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
            loading: {
                like: null,
                comment: null,
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
                    const icon = btn.querySelector('.follow-icon');
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
