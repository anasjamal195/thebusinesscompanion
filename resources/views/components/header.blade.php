@props([
    'title' => 'Dashboard',
])

<header class="sticky top-0 z-20 border-b border-gray-200 bg-white/80 backdrop-blur-md">
    <div class="flex items-center gap-4 px-6 py-4">
        <div class="min-w-0 flex-1">
            <h1 class="truncate text-xl font-extrabold text-gray-900 tracking-tight">{{ $title }}</h1>
        </div>

        <div class="hidden flex-1 justify-center md:flex">
            <div class="w-full max-w-md">
                <div class="relative group">
                    <input
                        type="search"
                        placeholder="Search projects, tasks..."
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/50 px-5 py-2.5 text-sm text-gray-900 placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-300"
                    />
                    <div class="absolute inset-y-0 right-4 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[22px]">search</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-1 items-center justify-end gap-4">
            <button class="relative inline-flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all active:scale-95" type="button" aria-label="Notifications">
                <span class="material-symbols-outlined text-[22px]">notifications</span>
                <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
            </button>

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
                        
                        <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">person</span>
                            Profile Settings
                        </a>
                        <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">payments</span>
                            Billing & Plans
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
