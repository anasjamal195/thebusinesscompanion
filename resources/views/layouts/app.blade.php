<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'dialer.best') }}</title>

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24;
                vertical-align: middle;
            }
            .material-symbols-outlined.fill {
                font-variation-settings: 'FILL' 1, 'wght' 450, 'GRAD' 0, 'opsz' 24;
            }

            .glass-panel {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }

            [x-cloak] {
                display: none !important;
            }

            .scrollbar-thin::-webkit-scrollbar {
                width: 4px;
            }
            .scrollbar-thin::-webkit-scrollbar-track {
                background: transparent;
            }
            .scrollbar-thin::-webkit-scrollbar-thumb {
                background: #d1d5db;
                border-radius: 99px;
            }
            .scrollbar-thin::-webkit-scrollbar-thumb:hover {
                background: #9ca3af;
            }

            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            @keyframes pulse-dot {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.4; }
            }
            .animate-pulse-dot {
                animation: pulse-dot 2s ease-in-out infinite;
            }

            .line-clamp-1 { overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 1; }
            .line-clamp-2 { overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; }
            .line-clamp-3 { overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3; }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script async src="https://www.googletagmanager.com/gtag/js?id=G-J7LP5YXVEH"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-J7LP5YXVEH');
        </script>
    </head>
    <body class="bg-background text-on-background font-sans antialiased">
        <div class="min-h-screen flex">
            <x-sidebar :active="$activeNav ?? 'dashboard'" :activeProjectId="$activeProjectId ?? null" :activeTaskId="$activeTaskId ?? null" />

            <div class="flex-1 flex flex-col min-h-screen lg:pl-60">
                <x-header :title="$pageTitle ?? ($title ?? 'Dashboard')" />

                <main class="flex-1 px-6 py-6">
                    <div class="@if(!isset($fullWidth) || !$fullWidth) max-w-7xl @else max-w-none @endif mx-auto">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
