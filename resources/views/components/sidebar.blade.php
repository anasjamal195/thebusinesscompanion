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
                    <div class="text-[17px] font-black text-gray-900 tracking-tight">The Business</div>
                    <div class="text-[11px] font-bold text-primary uppercase tracking-widest">Companion</div>
                </div>
            </a>
        </div>

        <nav class="mt-10 px-4 space-y-1">
            @php
                $navItems = [
                    ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'grid_view', 'href' => url('/dashboard')],
                    ['key' => 'projects', 'label' => 'Projects', 'icon' => 'folder', 'href' => route('projects.index')],
                    ['key' => 'reports', 'label' => 'Reports', 'icon' => 'analytics', 'href' => '#'],
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

        <div class="mt-8 px-6">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[11px] font-black uppercase tracking-widest text-gray-400">Your Projects</span>
                <a href="{{ route('projects.index') }}" class="text-primary hover:text-primary-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                </a>
            </div>

            @auth
                <div class="space-y-2" x-data="{ expandedProject: {{ $activeProjectId ?? 'null' }} }">
                    @php
                        $projects = auth()->user()
                            ->projects()
                            ->latest('id')
                            ->get(['id', 'name']);
                    @endphp

                    @foreach ($projects as $project)
                        @php $isCurrent = (string) $activeProjectId === (string) $project->id; @endphp
                        <div class="space-y-1">
                            <button 
                                @click="expandedProject = (expandedProject === {{ $project->id }} ? null : {{ $project->id }})"
                                class="w-full flex items-center justify-between rounded-2xl px-4 py-2.5 text-sm font-bold transition-all duration-200 {{ $isCurrent ? 'bg-gray-50 text-gray-900' : 'text-gray-500 hover:bg-gray-50' }}"
                            >
                                <div class="flex items-center gap-3 truncate">
                                    <span class="w-2 h-2 rounded-full {{ $isCurrent ? 'bg-primary' : 'bg-gray-300' }}"></span>
                                    <span class="truncate">{{ $project->name }}</span>
                                </div>
                                <span class="material-symbols-outlined text-[18px] transition-transform duration-300" :class="{ 'rotate-180': expandedProject === {{ $project->id }} }">expand_more</span>
                            </button>

                            <div 
                                x-show="expandedProject === {{ $project->id }}" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="pl-9 pr-2 py-1 space-y-1"
                                x-cloak
                            >
                                @php
                                    $tasks = \App\Models\Task::where('project_id', $project->id)->latest('id')->limit(5)->get();
                                @endphp
                                @foreach($tasks as $task)
                                    <a 
                                        href="{{ route('projects.show', $project) }}?task={{ $task->id }}" 
                                        class="block py-1 text-xs font-medium text-gray-500 hover:text-primary truncate transition-colors"
                                        title="{{ $task->title }}"
                                    >
                                        {{ $task->title }}
                                    </a>
                                @endforeach
                                @if($tasks->isEmpty())
                                    <span class="block py-1 text-[10px] text-gray-400 italic">No tasks yet</span>
                                @endif
                                <a href="{{ route('projects.show', $project) }}" class="block py-1 text-[10px] font-bold text-primary hover:underline">+ New Task</a>
                            </div>
                        </div>
                    @endforeach
                    
                    @if ($projects->isEmpty())
                        <div class="rounded-2xl bg-gray-50 px-4 py-8 text-center">
                            <p class="text-xs font-medium text-gray-400">No active projects</p>
                            <a href="{{ route('projects.index') }}" class="mt-2 inline-block text-xs font-bold text-primary hover:underline">Start a project</a>
                        </div>
                    @endif
                </div>
            @endauth
        </div>

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
