@props([
    'active' => 'dashboard',
    'activeProjectId' => null,
    'activeTaskId' => null,
])

<aside class="hidden lg:flex fixed inset-y-0 left-0 z-30 w-60 flex-col border-r border-gray-200 bg-white">
    <div class="flex h-14 items-center gap-3 px-5 border-b border-gray-100">
        <a href="{{ url('/dashboard') }}" class="flex items-center gap-2.5">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-white shadow-sm">
                <span class="material-symbols-outlined text-[18px]">smart_toy</span>
            </span>
            <div class="leading-tight">
                <div class="text-sm font-bold text-gray-900 tracking-tight">dialer</div>
                <div class="text-[9px] font-semibold text-primary uppercase tracking-[0.2em]">.best</div>
            </div>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto scrollbar-thin px-3 py-4 space-y-0.5">
        @php
            $navGroups = [
                'Main' => [
                    ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'grid_view', 'href' => route('dashboard')],
                    ['key' => 'feed', 'label' => 'Feed', 'icon' => 'dynamic_feed', 'href' => route('community.feed')],
                    ['key' => 'community', 'label' => 'Community', 'icon' => 'groups', 'href' => route('community.feed')],
                ],
                'Growth' => [
                    ['key' => 'challenges', 'label' => 'Challenges', 'icon' => 'flag', 'href' => route('challenges.index')],
                    ['key' => 'mentors', 'label' => 'Mentors', 'icon' => 'school', 'href' => route('mentors.index')],
                    ['key' => 'achievements', 'label' => 'Achievements', 'icon' => 'emoji_events', 'href' => route('achievements.index')],
                    ['key' => 'hall-of-fame', 'label' => 'Hall of Fame', 'icon' => 'military_tech', 'href' => route('hall-of-fame.index')],
                ],
                'Productivity' => [
                    ['key' => 'tasks', 'label' => 'Tasks', 'icon' => 'checklist', 'href' => route('dashboard')],
                    ['key' => 'calls', 'label' => 'Call Logs', 'icon' => 'call_log', 'href' => route('calls.index')],
                    ['key' => 'reports', 'label' => 'Reports', 'icon' => 'summarize', 'href' => route('reports.index')],
                ],
            ];
        @endphp

        @foreach ($navGroups as $groupName => $items)
            <div class="mb-4">
                <div class="px-3 py-1.5 text-[10px] font-semibold text-gray-400 uppercase tracking-[0.1em]">{{ $groupName }}</div>
                @foreach ($items as $item)
                    @php $isActive = $active === $item['key']; @endphp
                    <a
                        href="{{ $item['href'] }}"
                        class="{{ $isActive ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 font-medium' }} group flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm transition-all duration-150"
                    >
                        <span class="material-symbols-outlined text-[20px]">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @endforeach
    </nav>

    <div class="border-t border-gray-100 p-3">
        @auth
            <div class="flex items-center gap-3 px-2 py-2">
                <div class="h-8 w-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-semibold text-xs shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <div class="truncate text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                    <div class="flex items-center gap-1 text-[11px] text-gray-400">
                        <span class="material-symbols-outlined text-[12px]">account_balance_wallet</span>
                        {{ number_format(auth()->user()->credits, 2) }}
                    </div>
                </div>
            </div>
            <div class="mt-1 flex items-center gap-1">
                <a href="{{ route('settings.index') }}" class="flex-1 flex items-center justify-center gap-1.5 rounded-lg py-2 text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-all">
                    <span class="material-symbols-outlined text-[16px]">settings</span>
                    Settings
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-1.5 rounded-lg py-2 px-3 text-xs font-medium text-gray-500 hover:bg-red-50 hover:text-red-500 transition-all">
                        <span class="material-symbols-outlined text-[16px]">logout</span>
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="block w-full text-center bg-primary text-white rounded-lg py-2.5 font-semibold text-sm shadow-sm hover:bg-primary-container transition-all">Sign In</a>
        @endauth
    </div>
</aside>
