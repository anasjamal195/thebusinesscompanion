<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'The Business Companion AI') }}</title>

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
                            "primary-container": "#2563eb",
                            "primary-fixed": "#dbe1ff",
                            "background": "#f7f9fb",
                            "surface": "#f7f9fb",
                            "on-surface": "#191c1e",
                            "on-surface-variant": "#434655",
                            "on-background": "#191c1e",
                        },
                        fontFamily: {
                            sans: ["Inter", "sans-serif"],
                        }
                    },
                },
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

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background text-on-background font-sans antialiased">
        <div class="min-h-dvh">
            <x-sidebar :active="$activeNav ?? 'dashboard'" :activeProjectId="$activeProjectId ?? null" :activeTaskId="$activeTaskId ?? null" />

            <div class="pl-[260px]">
                <x-header :title="$pageTitle ?? ($title ?? 'Dashboard')" />

                <main class="px-6 py-8 min-h-[calc(100dvh-73px)]">
                    <div class="max-w-7xl mx-auto">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
