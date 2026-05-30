@props([
    'title' => 'Dashboard',
])

@php
    $unreadNotifications = auth()->check() ? auth()->user()->notifications()->unread()->latest()->take(5)->get() : collect();
    $unreadCount = auth()->check() ? auth()->user()->notifications()->unread()->count() : 0;
@endphp

<header class="sticky top-0 z-20 border-b border-gray-200 bg-white/80 backdrop-blur-md">
    <div class="flex items-center gap-4 px-6 py-4">
        <div class="min-w-0 flex-1">
            <h1 class="truncate text-xl font-extrabold text-gray-900 tracking-tight">{{ $title }}</h1>
        </div>

        <div class="flex flex-1 items-center justify-end gap-2">
            @auth
                <a href="{{ route('profile.index') }}" class="hidden md:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-primary/5 text-primary font-bold text-xs border border-primary/10 hover:bg-primary/10 transition-all">
                    <span class="material-symbols-outlined text-[16px]">account_balance_wallet</span>
                    {{ number_format(auth()->user()->credits, 2) }}
                </a>
            @endauth

            @auth
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        @click.away="open = false"
                        class="relative inline-flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all active:scale-95"
                        :class="{ 'ring-2 ring-primary/20 border-primary': open }"
                        type="button"
                        aria-label="Notifications"
                    >
                        <span class="material-symbols-outlined text-[22px]">notifications</span>
                        @if($unreadCount > 0)
                            <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        @endif
                    </button>

                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                        class="absolute right-0 mt-2 w-80 origin-top-right rounded-2xl border border-gray-200 bg-white p-2 shadow-xl shadow-gray-200/50 z-50"
                        x-cloak
                    >
                        <div class="px-3 py-2 mb-1 border-b border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                                Notifications
                                @if($unreadCount > 0)
                                    <span class="ml-1.5 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold text-white bg-red-500 rounded-full min-w-[18px]">{{ $unreadCount }}</span>
                                @endif
                            </p>
                        </div>

                        @forelse($unreadNotifications as $notification)
                            <div class="flex items-start gap-3 px-3 py-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                <span class="w-8 h-8 rounded-lg bg-red-100 text-red-500 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">phone_missed</span>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-bold text-gray-900">{{ $notification->title }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $notification->message }}</p>
                                    <p class="text-[10px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
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
                        class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white p-1.5 pr-3 hover:bg-gray-50 hover:border-gray-300 transition-all active:scale-95"
                        :class="{ 'ring-2 ring-primary/20 border-primary': open }"
                        type="button"
                    >
                        <div class="h-8 w-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="hidden text-sm font-semibold text-gray-700 sm:inline">{{ auth()->user()->name }}</span>
                        <span class="material-symbols-outlined text-[18px] text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': open }">expand_more</span>
                    </button>

                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                        class="absolute right-0 mt-2 w-56 origin-top-right rounded-2xl border border-gray-200 bg-white p-2 shadow-xl shadow-gray-200/50 z-50"
                        x-cloak
                    >
                        <div class="px-3 py-2 mb-2 border-b border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Account</p>
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">person</span>
                            My Profile
                        </a>
                        <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">settings</span>
                            Settings
                        </a>
                        <div class="my-1 border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="rounded-xl bg-primary px-5 py-2.5 text-sm font-bold text-white hover:bg-primary-container transition-all active:scale-95 shadow-lg shadow-primary/20">Login</a>
            @endauth
        </div>
    </div>
</header>
