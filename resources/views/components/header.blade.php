@props([
    'title' => 'Dashboard',
])

<header class="sticky top-0 z-20 border-b border-gray-200 bg-white">
    <div class="flex items-center gap-4 px-6 py-4">
        <div class="min-w-0 flex-1">
            <h1 class="truncate text-lg font-semibold text-gray-900">{{ $title }}</h1>
        </div>

        <div class="hidden flex-1 justify-center md:flex">
            <div class="w-full max-w-md">
                <div class="relative">
                    <input
                        type="search"
                        placeholder="Search projects, tasks, reports..."
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-500 focus:border-blue-500 focus:ring-blue-500"
                    />
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true">
                            <path d="M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" stroke="currentColor" stroke-width="1.8" />
                            <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-1 items-center justify-end gap-3">
            <button class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50" type="button" aria-label="Notifications">
                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true">
                    <path d="M12 22a2.2 2.2 0 0 0 2.2-2.2H9.8A2.2 2.2 0 0 0 12 22Z" fill="currentColor" opacity="0.25" />
                    <path d="M18 9a6 6 0 1 0-12 0c0 7-3 7-3 7h18s-3 0-3-7Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                </svg>
            </button>

            @auth
                <button class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-2 py-2 hover:bg-gray-50" type="button" aria-label="User menu">
                    <div class="h-8 w-8 rounded-full bg-gray-100 ring-1 ring-gray-200"></div>
                    <span class="hidden text-sm font-medium text-gray-900 sm:inline">{{ auth()->user()->name }}</span>
                    <svg viewBox="0 0 20 20" fill="currentColor" class="hidden h-4 w-4 text-gray-500 sm:inline" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 0 1 1.414 0L10 10.586l3.293-3.293a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 0-1.414Z" clip-rule="evenodd" />
                    </svg>
                </button>
            @else
                <a href="{{ route('login') }}" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 hover:bg-gray-50">Login</a>
            @endauth
        </div>
    </div>
</header>
