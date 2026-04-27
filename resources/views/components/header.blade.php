@props([
    'title' => 'Dashboard',
])

<header class="sticky top-0 z-20 border-b border-gray-100 bg-white/80 backdrop-blur-md">
    <div class="flex items-center gap-4 px-8 py-4">
        <div class="min-w-0 flex-1">
            <h1 class="truncate text-xl font-black text-gray-900 tracking-tight">{{ $title }}</h1>
        </div>

        <div class="hidden flex-1 justify-center md:flex">
            <div class="w-full max-w-md group">
                <div class="relative">
                    <input
                        type="search"
                        placeholder="Search anything..."
                        class="w-full rounded-2xl border border-gray-100 bg-gray-50/50 px-5 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:border-primary/30 focus:ring-4 focus:ring-primary/5 transition-all duration-300"
                    />
                    <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-1 items-center justify-end gap-4">
            <button class="relative inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-gray-100 bg-white text-gray-500 hover:text-primary hover:border-primary/20 hover:bg-primary/5 transition-all duration-300 group" type="button" aria-label="Notifications">
                <span class="material-symbols-outlined text-[24px]">notifications</span>
                <span class="absolute top-2.5 right-2.5 h-2 w-2 rounded-full bg-primary ring-2 ring-white"></span>
            </button>

            @auth
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button 
                        @click="open = !open"
                        class="flex items-center gap-3 rounded-2xl border border-gray-100 bg-white p-1.5 pr-4 hover:border-primary/20 hover:bg-primary/5 transition-all duration-300 group" 
                        type="button" 
                        aria-label="User menu"
                    >
                        <div class="h-8 w-8 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold text-xs border border-primary/20 group-hover:scale-105 transition-transform">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="hidden text-sm font-bold text-gray-700 sm:inline group-hover:text-primary transition-colors">{{ auth()->user()->name }}</span>
                        <span class="material-symbols-outlined text-[20px] text-gray-400 group-hover:text-primary transition-all" :class="open ? 'rotate-180' : ''">expand_more</span>
                    </button>

                    <!-- Profile Dropdown -->
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                        class="absolute right-0 mt-3 w-56 origin-top-right rounded-[1.5rem] bg-white p-2 shadow-2xl ring-1 ring-black/5 focus:outline-none z-50 border border-gray-100"
                    >
                        <div class="px-3 py-2 mb-2 border-b border-gray-50">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Signed in as</p>
                            <p class="text-xs font-bold text-gray-900 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-primary/5 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">person</span>
                            My Profile
                        </a>
                        <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-primary/5 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">settings</span>
                            Settings
                        </a>
                        <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-primary/5 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">credit_card</span>
                            Billing
                        </a>
                        
                        <div class="my-2 border-t border-gray-50"></div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-bold text-red-500 hover:bg-red-50 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="rounded-2xl bg-primary px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all active:scale-95">Login</a>
            @endauth
        </div>
    </div>
</header>

