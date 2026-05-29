@props([
    'active' => 'dashboard',
    'activeProjectId' => null,
    'activeTaskId' => null,
])

<aside class="fixed inset-y-0 left-0 z-30 w-[260px] border-r border-gray-200 bg-white">
    <div class="flex h-full flex-col">
        <div class="px-6 pt-8">
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3">
                <span class="relative inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary text-white shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-[24px]">smart_toy</span>
                </span>
                <div class="leading-tight">
                    <div class="text-[17px] font-black text-gray-900 tracking-tight">Dialer</div>
                    <div class="text-[11px] font-bold text-primary uppercase tracking-widest">.Best</div>
                </div>
            </a>
        </div>

        <nav class="mt-10 px-4 space-y-1">
            @php
                $navItems = [
                    ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'grid_view', 'href' => route('dashboard')],
                    ['key' => 'reports',  'label' => 'Reports',   'icon' => 'summarize', 'href' => route('reports.index')],
                    ['key' => 'calls',    'label' => 'Call Logs', 'icon' => 'history',   'href' => route('calls.index')],
                ];
            @endphp

            @foreach ($navItems as $item)
                @php $isActive = $active === $item['key']; @endphp
                <a
                    href="{{ $item['href'] }}"
                    class="{{ $isActive ? 'bg-primary/10 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition-all duration-200"
                >
                    <span class="material-symbols-outlined text-[22px]">{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="mt-auto p-4">
            <div class="bg-gray-50 rounded-[2rem] p-4 border border-gray-100">
                @auth
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <div class="truncate text-sm font-bold text-gray-900">{{ auth()->user()->name }}</div>
                            <div class="truncate text-[10px] font-bold text-gray-400 uppercase tracking-wider">Business Pro</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('settings.index') }}" class="flex-1 flex items-center justify-center gap-2 bg-white rounded-xl py-2 text-xs font-bold text-gray-700 border border-gray-200 shadow-sm hover:bg-gray-50 transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[18px]">settings</span>
                            Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="p-2 rounded-xl bg-white text-red-500 border border-gray-200 shadow-sm hover:bg-red-50 hover:border-red-100 transition-all active:scale-95">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center bg-primary text-white rounded-2xl py-3 font-bold text-sm shadow-lg shadow-primary/20 hover:bg-primary-container transition-all active:scale-95">Sign In</a>
                @endauth
            </div>
        </div>
    </div>
</aside>
