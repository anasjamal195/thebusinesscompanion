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
<body class="bg-background text-on-background font-body-md selection:bg-primary-fixed selection:text-on-primary-fixed min-h-screen flex flex-col">
    <!-- TopNavBar -->
    <nav class="docked full-width top-0 z-50 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 shadow-sm fixed w-full">
        <div class="flex justify-between items-center h-16 px-6 md:px-12 max-w-7xl mx-auto font-inter antialiased tracking-tight">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-tighter text-slate-900 dark:text-white">
                The Business Companion
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
</body>
</html>
