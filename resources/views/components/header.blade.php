@props([
    'title' => 'Dashboard',
])

@php
    $unreadNotifications = auth()->check() ? auth()->user()->notifications()->unread()->latest()->take(5)->get() : collect();
    $unreadCount = auth()->check() ? auth()->user()->notifications()->unread()->count() : 0;
@endphp

<header class="sticky top-0 z-20 border-b border-gray-200 bg-white/90 backdrop-blur-md">
    <div class="flex items-center justify-between gap-4 px-6 h-14">
        <div class="flex items-center gap-3 min-w-0">
            <h1 class="truncate text-lg font-bold text-gray-900 tracking-tight">{{ $title }}</h1>
        </div>

        <div class="flex items-center gap-2">
            @auth
                <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-subtle text-gray-600 font-medium text-xs border border-gray-200/50 hover:bg-gray-200 transition-all">
                    <span class="material-symbols-outlined text-[15px]">account_balance_wallet</span>
                    {{ number_format(auth()->user()->credits, 2) }}
                </a>
            @endauth

            @auth
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        @click.away="open = false"
                        class="relative inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-all"
                        :class="{ 'ring-2 ring-primary/20 border-primary': open }"
                        type="button"
                        aria-label="Notifications"
                    >
                        <span class="material-symbols-outlined text-[20px]">notifications</span>
                        @if($unreadCount > 0)
                            <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white animate-pulse-dot"></span>
                        @endif
                    </button>

                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                        class="absolute right-0 mt-2 w-80 origin-top-right rounded-xl border border-gray-200 bg-white p-2 shadow-lg shadow-gray-200/50 z-50"
                        x-cloak
                    >
                        <div class="flex items-center justify-between px-3 py-2 mb-1 border-b border-gray-100">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Notifications
                            </p>
                            @if($unreadCount > 0)
                                <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold text-white bg-red-500 rounded-full min-w-[18px]">{{ $unreadCount }}</span>
                            @endif
                        </div>

                        @forelse($unreadNotifications as $notification)
                            <div class="flex items-start gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 transition-colors group">
                                <span class="w-7 h-7 rounded-lg bg-red-100 text-red-500 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[16px]">phone_missed</span>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $notification->message }}</p>
                                    <p class="text-[11px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                <form action="{{ route('notifications.read', $notification) }}" method="POST" class="shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    <button type="submit" class="p-1 text-gray-400 hover:text-gray-600" title="Dismiss">
                                        <span class="material-symbols-outlined text-[16px]">close</span>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <span class="material-symbols-outlined text-3xl text-gray-300 mb-2">notifications_off</span>
                                <p class="text-sm text-gray-500 font-medium">All clear!</p>
                                <p class="text-xs text-gray-400 mt-0.5">No new notifications.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endauth

            @auth
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        @click.away="open = false"
                        class="flex items-center gap-2 rounded-lg border border-gray-200 bg-white pl-1.5 pr-2.5 py-1.5 hover:bg-gray-100 hover:border-gray-300 transition-all"
                        :class="{ 'ring-2 ring-primary/20 border-primary': open }"
                        type="button"
                    >
                        <div class="h-7 w-7 rounded-md bg-primary/10 text-primary flex items-center justify-center font-semibold text-xs">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="hidden text-sm font-medium text-gray-700 sm:inline max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                        <span class="material-symbols-outlined text-[16px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }">expand_more</span>
                    </button>

                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                        class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl border border-gray-200 bg-white p-1.5 shadow-lg shadow-gray-200/50 z-50"
                        x-cloak
                    >
                        <div class="px-3 py-2 mb-1 border-b border-gray-100">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider leading-none mb-1">Account</p>
                            <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <a href="{{ route('profile.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[18px]">person</span>
                            My Profile
                        </a>
                        <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[18px]">settings</span>
                            Settings
                        </a>
                        <div class="my-1 border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary-container transition-all shadow-sm">Sign In</a>
            @endauth
        </div>
    </div>
</header>
