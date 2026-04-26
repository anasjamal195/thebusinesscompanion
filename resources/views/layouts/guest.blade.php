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
    </style>
</head>
<body class="bg-background text-on-background font-body-md selection:bg-primary-fixed selection:text-on-primary-fixed min-h-screen flex flex-col"
    x-data="{ waitlistModalOpen: false, waitlistSubmitted: false, email: '', password: '' }">
    <!-- TopNavBar -->
    <nav class="docked full-width top-0 z-50 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 shadow-sm fixed w-full">
        <div class="flex justify-between items-center h-16 px-6 md:px-12 max-w-7xl mx-auto font-inter antialiased tracking-tight">
            <a href="{{ url('/') }}" class="font-black tracking-tighter text-slate-900 dark:text-white flex items-baseline">
                <span class="text-sm font-bold opacity-40 uppercase mr-0.5">The</span><span class="text-primary text-2xl">Business</span><span class="text-dark text-2xl">Companion</span>
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a class="text-blue-600 dark:text-blue-400 font-semibold border-b-2 border-blue-600 py-1" href="{{ url('/companions') }}">Product</a>
                <a class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 transition-colors py-1" href="#">Features</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ url('/login') }}" class="text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-900 transition-all duration-200 px-4 py-2 rounded-lg text-sm font-medium">Sign In</a>
                <button @click="waitlistModalOpen = true" class="bg-primary hover:bg-primary-container text-white active:scale-95 transition-all duration-200 px-5 py-2 rounded-lg text-sm font-semibold shadow-md">Join Waitlist</button>
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
                <div class="font-black tracking-tighter text-slate-900 dark:text-white flex items-baseline">
                    <span class="text-xs font-bold opacity-40 uppercase mr-0.5">The</span><span class="text-primary text-xl">Business</span><span class="text-dark text-xl">Companion</span>
                </div>
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
        @keydown.escape.window="waitlistModalOpen = false">
        <div class="bg-white rounded-[2rem] p-6 md:p-10 max-w-2xl w-full shadow-2xl relative border border-gray-100 overflow-hidden"
            @click.away="waitlistModalOpen = false">
            
            <button @click="waitlistModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <span class="material-symbols-outlined">close</span>
            </button>

            <div x-show="!waitlistSubmitted" class="flex flex-col md:flex-row gap-8 items-center">
                <!-- Icon/Side Decor -->
                <div class="hidden md:flex w-1/3 aspect-square bg-primary/10 rounded-2xl items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-6xl">upcoming</span>
                </div>

                <div class="flex-1 flex flex-col justify-center text-center md:text-left">
                    <h3 class="text-3xl font-black text-gray-900 mb-2 tracking-tight">Access Beta</h3>
                    <p class="text-gray-500 mb-6 text-sm">Leave your email to get early access and we'll update you soon.</p>

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
                                    alert('Please check your email address.');
                                }
                            })
                        " class="space-y-4">
                        <div class="relative">
                            <input type="email" x-model="email" required placeholder="Business Email"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition font-medium">
                        </div>
                        <button type="submit"
                            class="w-full py-3.5 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-container transition-all active:scale-95 flex items-center justify-center gap-2">
                            Join Waitlist
                            <span class="material-symbols-outlined text-sm">send</span>
                        </button>
                    </form>
                </div>
            </div>

            <div x-show="waitlistSubmitted" class="text-center py-4">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-600 mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl">check</span>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">You're on the list!</h3>
                <p class="text-gray-600 text-sm">We'll update you through email soon.</p>
                <button @click="waitlistModalOpen = false; waitlistSubmitted = false; email = ''"
                    class="mt-6 text-primary font-bold hover:underline">Close</button>
            </div>
        </div>
    </div>
</body>
</html>
