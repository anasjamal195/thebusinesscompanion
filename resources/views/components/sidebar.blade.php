@props([
    'active' => 'dashboard',
    'activeProjectId' => null,
    'activeTaskId' => null,
])

<aside class="fixed inset-y-0 left-0 z-30 w-[260px] border-r border-gray-100 bg-white shadow-[1px_0_10px_rgba(0,0,0,0.02)]">
    <div class="flex h-full flex-col">
        <div class="px-6 pt-8 pb-6">
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 group">
                <div class="font-black tracking-tighter text-slate-900 flex items-baseline leading-none">
                    <span class="text-[10px] font-bold opacity-30 uppercase mr-0.5">The</span>
                    <span class="text-primary text-xl">Business</span>
                    <span class="text-dark text-xl">Companion</span>
                </div>
            </a>
        </div>

        <nav class="mt-4 px-4 flex-grow overflow-y-auto no-scrollbar">
            @php
                $items = [
                    ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => url('/dashboard'), 'icon' => 'dashboard'],
                    ['key' => 'projects', 'label' => 'Projects', 'href' => url('/projects/acme'), 'icon' => 'workspaces'],
                    ['key' => 'tasks', 'label' => 'Tasks', 'href' => url('/projects/acme'), 'icon' => 'task_alt'],
                    ['key' => 'reports', 'label' => 'Reports', 'href' => url('/reports/weekly'), 'icon' => 'analytics'],
                ];
            @endphp

            <div class="space-y-1.5">
                @foreach ($items as $item)
                    @php
                        $isActive = $active === $item['key'];
                    @endphp
                    <a
                        href="{{ $item['href'] }}"
                        class="{{ $isActive ? 'bg-primary/5 text-primary shadow-sm ring-1 ring-primary/10' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200"
                    >
                        <span class="material-symbols-outlined text-[22px] transition-transform group-hover:scale-110 {{ $isActive ? 'text-primary' : 'text-gray-400 group-hover:text-gray-600' }}">
                            {{ $item['icon'] }}
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>

            @auth
                <div class="mt-10 mb-2 px-2 flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-[0.1em] text-gray-400">Your Projects</span>
                    <a href="{{ route('projects.index') }}" class="text-primary hover:text-primary-container transition-colors">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    </a>
                </div>

                @php
                    $projects = auth()->user()
                        ->projects()
                        ->latest('id')
                        ->limit(5)
                        ->get(['id', 'name']);
                @endphp

                <div class="space-y-1">
                    @foreach ($projects as $project)
                        @php $pActive = (string) $activeProjectId === (string) $project->id; @endphp
                        <div x-data="{ open: {{ $pActive ? 'true' : 'false' }} }">
                            <a
                                href="{{ route('projects.show', $project) }}"
                                class="{{ $pActive ? 'text-primary font-bold' : 'text-gray-600 hover:bg-gray-50' }} flex items-center justify-between rounded-xl px-3 py-2 text-sm transition-all"
                            >
                                <span class="truncate flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $pActive ? 'bg-primary animate-pulse' : 'bg-gray-300' }}"></span>
                                    {{ $project->name }}
                                </span>
                                @if ($pActive)
                                    <span class="material-symbols-outlined text-[18px] transition-transform" :class="open ? 'rotate-180' : ''" @click.prevent="open = !open">expand_more</span>
                                @endif
                            </a>

                            @if ($pActive)
                                <div x-show="open" x-collapse class="ml-4 mt-1 border-l-2 border-primary/10 pl-2 space-y-1">
                                    @php
                                        $tasks = \App\Models\Task::query()
                                            ->where('project_id', $project->id)
                                            ->where('user_id', auth()->id())
                                            ->latest('id')
                                            ->limit(5)
                                            ->get(['id', 'title']);
                                    @endphp
                                    @foreach ($tasks as $t)
                                        @php $tActive = (string) $activeTaskId === (string) $t->id; @endphp
                                        <a
                                            href="{{ route('projects.show', $project) }}?task={{ $t->id }}"
                                            class="{{ $tActive ? 'text-primary bg-primary/5 rounded-lg font-medium' : 'text-gray-500 hover:text-gray-700' }} block px-2 py-1.5 text-[13px] truncate"
                                            title="{{ $t->title }}"
                                        >
                                            {{ $t->title }}
                                        </a>
                                    @endforeach
                                    <a href="{{ route('projects.show', $project) }}" class="block px-2 py-1 text-[12px] text-primary/60 hover:text-primary font-medium italic">+ New Task</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    @if ($projects->isEmpty())
                        <div class="px-3 py-4 text-center rounded-2xl bg-gray-50 border border-dashed border-gray-200">
                            <p class="text-xs text-gray-400">No projects yet</p>
                            <a href="{{ route('onboarding.role') }}" class="text-[11px] text-primary font-bold hover:underline">Start here</a>
                        </div>
                    @endif
                </div>
            @endauth
        </nav>

        <div class="mt-auto p-4">
            <div class="rounded-3xl bg-gray-50 p-4 border border-gray-100">
                @auth
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-2xl bg-primary/10 flex items-center justify-center text-primary border border-primary/20">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                        <div class="min-w-0">
                            <div class="truncate text-sm font-bold text-gray-900">{{ auth()->user()->name }}</div>
                            <div class="truncate text-[11px] text-gray-500 font-medium">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="#" class="flex items-center justify-center gap-2 rounded-xl bg-white border border-gray-200 py-2 text-xs font-bold text-gray-700 hover:bg-gray-100 transition-all">
                            <span class="material-symbols-outlined text-[16px]">settings</span>
                            Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="flex">
                            @csrf
                            <button type="submit" class="flex-1 flex items-center justify-center gap-2 rounded-xl bg-white border border-gray-200 py-2 text-xs font-bold text-red-500 hover:bg-red-50 transition-all">
                                <span class="material-symbols-outlined text-[16px]">logout</span>
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block w-full rounded-2xl bg-primary px-4 py-3 text-center text-sm font-bold text-white shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all active:scale-95">Login</a>
                    <a href="{{ route('register') }}" class="mt-2 block w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-center text-sm font-bold text-gray-900 hover:bg-gray-100 transition-all">Sign up</a>
                @endauth
            </div>
        </div>
    </div>
</aside>

