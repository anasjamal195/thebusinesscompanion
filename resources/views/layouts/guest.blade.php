<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title ?? config('app.name', 'The Business Companion') }}</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#00AFF0",
                        blue: {
                            600: "#00AFF0",
                        },
                        "on-primary": "#ffffff",
                        "primary-fixed": "#dbe1ff",
                        "on-primary-fixed": "#00174b",
                        "primary-container": "#2563eb",
                        "on-primary-fixed-variant": "#003ea8",
                        secondary: "#006e2f",
                        "on-secondary": "#ffffff",
                        "secondary-fixed": "#6bff8f",
                        "on-secondary-fixed": "#002109",
                        "secondary-fixed-dim": "#4ae176",
                        "on-secondary-fixed-variant": "#005321",
                        background: "#f7f9fb",
                        "on-background": "#191c1e",
                        surface: "#f7f9fb",
                        "on-surface": "#191c1e",
                        "surface-variant": "#e0e3e5",
                        "on-surface-variant": "#434655",
                        outline: "#737686",
                        "outline-variant": "#c3c6d7",
                    },
                    fontFamily: {
                        "headline-lg": ["Inter"],
                        "headline-xl": ["Inter"],
                        "headline-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "label-xs": ["Inter"],
                        "label-sm": ["Inter"]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-background text-on-background font-body-md selection:bg-primary-fixed selection:text-on-primary-fixed min-h-screen flex flex-col"
    x-data="{ waitlistModalOpen: false, waitlistSubmitted: false, email: '' }">
    <!-- TopNavBar -->
    <nav class="docked full-width top-0 z-50 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 shadow-sm fixed w-full">
        <div class="flex justify-between items-center h-16 px-6 md:px-12 max-w-7xl mx-auto font-inter antialiased tracking-tight">
            <a href="{{ url('/') }}" class="font-black tracking-tighter text-slate-900 dark:text-white flex items-baseline">
                <span class="text-sm font-bold opacity-40 uppercase mr-0.5">The</span><span class="text-primary text-2xl">BusinessCompanion</span>
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a class="text-blue-600 dark:text-blue-400 font-semibold border-b-2 border-blue-600 py-1" href="{{ url('/companions') }}">Product</a>
                <a class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 transition-colors py-1" href="#">Features</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ url('/login') }}" class="text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-900 transition-all duration-200 px-4 py-2 rounded-lg text-sm font-medium">Sign In</a>
                <a href="{{ url('/companions') }}" class="bg-primary hover:bg-primary-container text-white active:scale-95 transition-all duration-200 px-5 py-2 rounded-lg text-sm font-semibold">Join Waitlist</a>
            </div>
        </div>
    </nav>
    
    <main class="pt-16 flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="full-width py-12 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 mt-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-6 md:px-12 max-w-7xl mx-auto font-inter">
            <div class="space-y-4">
                <div class="font-bold text-slate-900 dark:text-white text-lg">The Business Companion AI</div>
                <p class="text-sm text-slate-500 dark:text-slate-400 max-w-xs">
                    Revolutionizing professional productivity through contextual intelligence and voice-first interaction.
                </p>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8 mt-8 border-t border-slate-200 dark:border-slate-800 md:col-span-2">
                <div class="text-sm text-slate-500 dark:text-slate-400">© {{ date('Y') }} The Business Companion AI. Engineered for Excellence.</div>
            </div>
        </div>
    </footer>
    <!-- Waitlist Modal -->
    <div x-show="waitlistModalOpen" x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        @keydown.escape.window="waitlistModalOpen = false">
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 max-w-lg w-full shadow-2xl relative border border-gray-100"
            @click.away="waitlistModalOpen = false">
            <button @click="waitlistModalOpen = false"
                class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition">
                <span class="material-symbols-outlined text-3xl">close</span>
            </button>

            <div x-show="!waitlistSubmitted">
                <div class="mb-8">
                    <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6">
                        <span class="material-symbols-outlined text-3xl">mail</span>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 mb-3">Join the Waitlist</h3>
                    <p class="text-gray-500">We are currently in private beta. Leave your email to get early access when we
                        expand.
                    </p>
                </div>

                <form @submit.prevent="
                fetch('/waitlist', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(response => {
                    if (response.ok) {
                        waitlistSubmitted = true;
                    } else {
                        alert('Check your email address or you might already be on the list!');
                    }
                })
            "
                    class="space-y-4">
                    <input type="email" x-model="email" required placeholder="Enter your business email"
                        class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition font-medium">
                    <button type="submit"
                        class="w-full py-4 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/20 hover:bg-primary-container transition-all active:scale-95 flex items-center justify-center gap-2">
                        Reserve my spot
                        <span class="material-symbols-outlined">send</span>
                    </button>
                </form>
            </div>

            <div x-show="waitlistSubmitted" class="text-center py-8">
                <div
                    class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-green-600 mx-auto mb-8 animate-bounce">
                    <span class="material-symbols-outlined text-4xl">check_circle</span>
                </div>
                <h3 class="text-3xl font-black text-gray-900 mb-4">You're on the list!</h3>
                <p class="text-lg text-gray-600 leading-relaxed font-medium">You have been added to waitlist, we will
                    update you
                    through email</p>
                <button @click="waitlistModalOpen = false; waitlistSubmitted = false; email = ''"
                    class="mt-12 text-primary font-bold hover:underline">Close</button>
            </div>
        </div>
    </div>
</body>
</html>
