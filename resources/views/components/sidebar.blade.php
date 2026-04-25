@props([
    'active' => 'dashboard',
    'activeProjectId' => 'acme',
])

<aside class="fixed inset-y-0 left-0 z-30 w-[260px] border-r border-gray-200 bg-white">
    <div class="flex h-full flex-col">
        <div class="px-5 pt-6">
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-2">
                <span class="relative inline-flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                    <span class="text-sm font-semibold">BC</span>
                    <span class="absolute -right-0.5 -top-0.5 h-2 w-2 rounded-full bg-white ring-2 ring-blue-600"></span>
                </span>
                <div class="leading-tight">
                    <div class="text-[15px] font-semibold text-gray-900">Business Companion</div>
                    <div class="text-xs text-gray-500">AI workspace</div>
                </div>
            </a>
        </div>

        <nav class="mt-6 px-3">
            @php
                $items = [
                    ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => url('/dashboard')],
                    ['key' => 'projects', 'label' => 'Projects', 'href' => url('/projects/acme')],
                    ['key' => 'tasks', 'label' => 'Tasks', 'href' => url('/projects/acme')],
                    ['key' => 'reports', 'label' => 'Reports', 'href' => url('/reports/weekly')],
                ];
            @endphp

            <div class="space-y-1">
                @foreach ($items as $item)
                    @php
                        $isActive = $active === $item['key'];
                    @endphp
                    <a
                        href="{{ $item['href'] }}"
                        class="{{ $isActive ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} group flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium"
                    >
                        <span class="{{ $isActive ? 'bg-blue-600' : 'bg-gray-200 group-hover:bg-gray-300' }} h-2 w-2 rounded-full"></span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </nav>

        <div class="mt-6 px-5">
            <x-button href="{{ url('/onboarding/business') }}" class="w-full justify-center">+ New Project</x-button>
        </div>

        <div class="mt-8 px-5">
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Projects</div>

            @php
                $projects = [
                    ['id' => 'acme', 'name' => 'Acme Launch'],
                    ['id' => 'northstar', 'name' => 'Northstar Revamp'],
                    ['id' => 'atlas', 'name' => 'Atlas Research'],
                    ['id' => 'studio', 'name' => 'Studio Ops'],
                ];
            @endphp

            <div class="mt-3 space-y-1">
                @foreach ($projects as $project)
                    @php
                        $pActive = (string) $activeProjectId === (string) $project['id'];
                    @endphp
                    <a
                        href="{{ url('/projects/' . $project['id']) }}"
                        class="{{ $pActive ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} flex items-center justify-between rounded-xl px-3 py-2 text-sm"
                    >
                        <span class="truncate">{{ $project['name'] }}</span>
                        @if ($pActive)
                            <span class="text-xs font-semibold">Active</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-auto border-t border-gray-200 px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-gray-100 ring-1 ring-gray-200"></div>
                <div class="min-w-0">
                    <div class="truncate text-sm font-semibold text-gray-900">A. User</div>
                    <div class="truncate text-xs text-gray-500">user@company.com</div>
                </div>
            </div>
            <a href="#" class="mt-3 block rounded-xl px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>
        </div>
    </div>
</aside>

