<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Business Companion') }} - Onboarding</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#00AFF0",
                        "primary-container": "#009bd6",
                        "background": "#f8fafc",
                        "surface": "#ffffff",
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                },
            },
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-900 overflow-x-hidden">
    <div class="min-h-full flex flex-col">
        <!-- Progress Bar -->
        @isset($step)
        <div class="fixed top-0 left-0 w-full h-1.5 bg-slate-100 z-[60]">
            <div class="h-full bg-primary transition-all duration-500 ease-out" style="width: {{ ($step / 8) * 100 }}%"></div>
        </div>
        @endisset

        <!-- Header -->
        <header class="py-6 px-6 md:px-12 bg-white border-b border-slate-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="font-black tracking-tighter text-slate-900 flex items-baseline">
                        <span class="text-xs font-bold opacity-40 uppercase mr-0.5">The</span><span class="text-primary text-xl">Business</span><span class="text-slate-900 text-xl">Companion</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-4 text-sm font-medium text-slate-400">
                    <span class="px-3 py-1 bg-slate-50 rounded-full border border-slate-100">Onboarding Flow</span>
                </div>
            </div>
        </header>

        <main class="flex-grow flex items-center justify-center py-12 px-6 md:px-12">
            <div class="w-full max-w-4xl">
                @yield('content')
            </div>
        </main>

        <footer class="py-8 px-6 text-center text-sm text-slate-400 border-t border-slate-100 bg-white">
            <p>&copy; {{ date('Y') }} The Business Companion AI. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
