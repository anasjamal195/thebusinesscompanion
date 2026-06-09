<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-background">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'dialer.best') }} - Onboarding</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#00AFF0",
                        "primary-container": "#009bd6",
                        "background": "#f6f8fa",
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
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-J7LP5YXVEH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-J7LP5YXVEH');
    </script>
</head>
<body class="h-full font-sans antialiased text-gray-900 overflow-x-hidden">
    <div class="min-h-full flex flex-col">
        @isset($step)
        <div class="fixed top-0 left-0 w-full h-1 bg-gray-100 z-[60]">
            <div class="h-full bg-primary transition-all duration-500 ease-out rounded-full" style="width: {{ min(100, ($step / 6) * 100) }}%"></div>
        </div>
        @endisset

        <header class="py-4 px-6 bg-white border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-4xl mx-auto flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-md bg-primary text-white">
                        <span class="material-symbols-outlined text-[16px]">smart_toy</span>
                    </span>
                    <span class="text-sm font-bold text-gray-900">dialer.best</span>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-400">
                    <span class="px-2 py-1 bg-gray-100 rounded-md font-medium">Setup</span>
                    @isset($step)
                    <span class="font-medium">Step {{ $step }} of 6</span>
                    @endisset
                </div>
            </div>
        </header>

        <main class="flex-grow flex items-start justify-center py-10 px-6">
            <div class="w-full max-w-2xl">
                @yield('content')
            </div>
        </main>

        <footer class="py-6 px-6 text-center text-xs text-gray-400 border-t border-gray-100 bg-white">
            <p>&copy; {{ date('Y') }} dialer.best. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
