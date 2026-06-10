@props([
    'post',
    'postTypeMeta',
    'user',
    'showActions' => true,
    'showFollow' => false,
    'interactive' => false,
])

@php
    $pt = $postTypeMeta[$post->type] ?? ['label' => ucfirst($post->type), 'icon' => 'article', 'color' => 'bg-gray-50 text-gray-700'];
    $isOwner = $user && $user->id === $post->user_id;
@endphp

<div @if(!$interactive) x-data="{ editing: false, deleting: false, editContent: '' }" @endif class="bg-white rounded-xl border border-gray-200 shadow-sm">
    {{-- Header --}}
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
        <div class="flex items-center gap-2">
            @if($isOwner)
                <div class="flex items-center gap-1">
                    <button
                        @if($interactive)
                            @click="editPostId === {{ $post->id }} ? cancelEdit() : openEdit({{ $post->id }}, $el)"
                        @else
                            @click="editing = !editing; if(editing) editContent = '{{ addslashes($post->content) }}'"
                        @endif
                        data-content="{{ $post->content }}"
                        class="text-xs text-gray-400 hover:text-primary p-1 rounded hover:bg-gray-50 transition-colors"
                    >
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                    </button>
                    <button
                        @if($interactive)
                            @click="confirmDelete = {{ $post->id }}"
                        @else
                            @click="deleting = true"
                        @endif
                        class="text-xs text-gray-400 hover:text-red-500 p-1 rounded hover:bg-red-50 transition-colors"
                    >
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

    {{-- Content --}}
    <div class="px-4 py-2">
        {{-- Edit mode --}}
        @if($isOwner)
            <div
                @if($interactive)
                    x-show="editPostId === {{ $post->id }}"
                @else
                    x-show="editing"
                @endif
                x-cloak
                class="space-y-2"
            >
                <form action="{{ route('community.posts.update', $post) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <textarea
                        @if($interactive)
                            x-model="editContent"
                        @else
                            x-model="editContent"
                        @endif
                        name="content"
                        class="w-full rounded-lg border-gray-200 bg-gray-50 text-sm"
                        rows="3"
                    >{{ $post->content }}</textarea>
                    <div class="flex gap-2 mt-2">
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-primary text-white text-xs font-semibold">Save</button>
                        <button
                            type="button"
                            @if($interactive)
                                @click="cancelEdit()"
                            @else
                                @click="editing = false"
                            @endif
                            class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600"
                        >Cancel</button>
                    </div>
                </form>
            </div>
        @endif

        {{-- Content display --}}
        <div
            @if($isOwner)
                @if($interactive)
                    x-show="editPostId !== {{ $post->id }}"
                @else
                    x-show="!editing"
                @endif
            @endif
        >
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
                <p class="text-sm text-gray-800 leading-relaxed mb-4">{{ $post->content }}</p>
                <div class="bg-gradient-to-br {{ $theme['card'] }} rounded-xl border {{ $theme['border'] }} p-4 space-y-4">
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
                            <div class="text-2xl font-bold {{ $theme['text'] }}">{{ $pct }}%</div>
                            <div class="text-[10px] font-medium uppercase tracking-wider text-gray-400">Score</div>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="h-2.5 rounded-full transition-all duration-500 {{ $theme['bar'] }}" style="width: {{ $pct }}%"></div>
                    </div>
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
    @if($showActions)
        <div class="flex items-center gap-1 px-4 py-2.5 border-t border-gray-50">
            <button
                @if($interactive)
                    @click.prevent="toggleLike({{ $post->id }}, $el)"
                @endif
                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors
                    @if($interactive)
                        {{ $post->isLikedBy($user) ? 'text-red-500 bg-red-50' : 'text-gray-400 hover:text-red-500 hover:bg-red-50' }}
                    @else
                        text-gray-400
                    @endif"
                @if($interactive) :disabled="loading.like === {{ $post->id }}" @endif
            >
                <span
                    @if($interactive)
                        x-show="loading.like === {{ $post->id }}"
                    @endif
                    class="material-symbols-outlined text-[18px] animate-spin"
                    @if($interactive) x-cloak @endif
                >progress_activity</span>
                <span
                    @if($interactive)
                        x-show="loading.like !== {{ $post->id }}"
                    @endif
                    class="{{ $interactive ? 'like-icon ' : '' }}material-symbols-outlined text-[18px]"
                >{{ $post->isLikedBy($user) ? 'favorite' : 'favorite_border' }}</span>
                <span class="like-count">{{ $post->likes_count ?? $post->likes->count() }}</span>
            </button>

            <button
                @if($interactive)
                    @click="commentPost = commentPost === {{ $post->id }} ? null : {{ $post->id }}"
                @endif
                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium
                    @if($interactive)
                        text-gray-400 hover:text-primary hover:bg-blue-50 transition-colors
                    @else
                        text-gray-400
                    @endif"
            >
                <span class="material-symbols-outlined text-[18px]">comment</span>
                <span>{{ $post->comments_count ?? $post->comments->count() }}</span>
            </button>

            @if($showFollow && $user && $user->id !== $post->user_id)
                <button
                    @if($interactive)
                        @click.prevent="toggleFollow({{ $post->user->id }}, $el)"
                    @endif
                    class="text-xs font-medium text-primary hover:text-primary-container transition-colors flex items-center gap-1 px-2 py-1 rounded hover:bg-blue-50 ml-auto"
                    @if($interactive) :disabled="loading.follow === {{ $post->user->id }}" @endif
                >
                    <span
                        @if($interactive)
                            x-show="loading.follow === {{ $post->user->id }}"
                            class="material-symbols-outlined text-[14px] animate-spin"
                        @endif
                    >progress_activity</span>
                    <span
                        @if($interactive)
                            x-show="loading.follow !== {{ $post->user->id }}"
                        @endif
                        class="{{ $interactive ? 'follow-icon ' : '' }}material-symbols-outlined text-[14px]"
                    >{{ $user && $user->following()->where('following_id', $post->user->id)->exists() ? 'check' : 'person_add' }}</span>
                    <span class="follow-text">{{ $user && $user->following()->where('following_id', $post->user->id)->exists() ? 'Following' : 'Follow' }}</span>
                </button>
            @endif
        </div>
    @endif

    {{-- Comments Section --}}
    @if($showActions)
        <div
            @if($interactive)
                x-show="commentPost === {{ $post->id }}"
                data-comments-section="{{ $post->id }}"
            @endif
            @if($interactive) x-cloak @endif
            class="border-t border-gray-100 px-4 py-4 space-y-3"
        >
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

            @if($interactive)
                <form @submit.prevent="submitComment({{ $post->id }})" class="flex items-center gap-2">
                    @csrf
                    <input type="text" name="content" required maxlength="2000" placeholder="Write a comment..." data-comment-input="{{ $post->id }}" class="flex-1 rounded-lg border-gray-200 bg-gray-50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                    <button type="submit" class="px-3 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm flex items-center gap-1" :disabled="loading.comment === {{ $post->id }}">
                        <span x-show="loading.comment === {{ $post->id }}" class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span>
                        <span x-show="loading.comment !== {{ $post->id }}" class="material-symbols-outlined text-[18px]">send</span>
                    </button>
                </form>
            @endif
        </div>
    @endif

    {{-- Delete Confirmation (non-interactive mode) --}}
    @if(!$interactive)
        <div x-show="deleting" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-black/20 backdrop-blur-sm" @click.away="deleting = false">
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
                    <button @click="deleting = false" class="flex-1 px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <form action="{{ route('community.posts.destroy', $post) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition-all shadow-sm">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
