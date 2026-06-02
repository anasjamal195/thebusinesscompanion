<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Panel' }} — {{ config('app.name', 'dialer.best') }}</title>

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

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-J7LP5YXVEH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-J7LP5YXVEH');
    </script>
</head>
<body class="bg-background text-on-background font-sans antialiased">
    <div class="min-h-dvh flex">
        <aside class="fixed inset-y-0 left-0 z-30 w-[260px] border-r border-gray-200 bg-white">
            <div class="flex h-full flex-col">
                <div class="px-6 pt-8">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <span class="relative inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary text-white shadow-lg shadow-primary/20">
                            <span class="material-symbols-outlined text-[24px]">shield</span>
                        </span>
                        <div class="leading-tight">
                            <div class="text-[17px] font-black text-gray-900 tracking-tight">Admin</div>
                            <div class="text-[11px] font-bold text-primary uppercase tracking-widest">Panel</div>
                        </div>
                    </a>
                </div>

                <nav class="mt-10 px-4 space-y-1 flex-1 overflow-y-auto">
                    @php
                        $navItems = [
                            ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'grid_view', 'route' => 'admin.dashboard'],
                            ['key' => 'users', 'label' => 'User Management', 'icon' => 'group', 'route' => 'admin.users.index'],
                            ['key' => 'calls', 'label' => 'Calls', 'icon' => 'history', 'route' => 'admin.calls.index'],
                            ['key' => 'payments', 'label' => 'Payments', 'icon' => 'payments', 'route' => 'admin.payments.index'],
                            ['key' => 'monetization', 'label' => 'Monetization Settings', 'icon' => 'tune', 'route' => 'admin.monetization.index'],
                            ['key' => 'waitlist', 'label' => 'Waitlist', 'icon' => 'list_alt', 'route' => 'admin.waitlist.index'],
                        ];
                        $currentKey = $activeNav ?? 'dashboard';
                    @endphp

                    @foreach ($navItems as $item)
                        @php $isActive = $currentKey === $item['key']; @endphp
                        <a href="{{ route($item['route']) }}"
                            class="{{ $isActive ? 'bg-primary/10 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition-all duration-200">
                            <span class="material-symbols-outlined text-[22px]">{{ $item['icon'] }}</span>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>

                <div class="mt-auto p-4 border-t border-gray-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-10 w-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <div class="truncate text-sm font-bold text-gray-900">{{ auth()->user()->name }}</div>
                            <div class="truncate text-[10px] font-bold text-gray-400 uppercase tracking-wider">Admin</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('dashboard') }}" class="flex-1 flex items-center justify-center gap-2 bg-white rounded-xl py-2 text-xs font-bold text-gray-700 border border-gray-200 shadow-sm hover:bg-gray-50 transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                            App
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="p-2 rounded-xl bg-white text-red-500 border border-gray-200 shadow-sm hover:bg-red-50 hover:border-red-100 transition-all active:scale-95">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <div class="pl-[260px] flex-1">
            <header class="sticky top-0 z-20 border-b border-gray-200 bg-white/80 backdrop-blur-md">
                <div class="flex items-center gap-4 px-6 py-4">
                    <h1 class="truncate text-xl font-extrabold text-gray-900 tracking-tight">{{ $pageTitle ?? ($title ?? 'Admin Dashboard') }}</h1>
                    <div class="flex-1"></div>
                    <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-gray-500 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        Back to App
                    </a>
                </div>
            </header>

            <main class="px-6 py-8 min-h-[calc(100dvh-73px)]">
                <div class="max-w-7xl mx-auto">
                    @if (session('success'))
                        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-5 py-4 text-sm font-semibold text-green-700 flex items-center gap-3">
                            <span class="material-symbols-outlined text-green-500">check_circle</span>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-5 py-4 text-sm font-semibold text-red-700 flex items-center gap-3">
                            <span class="material-symbols-outlined text-red-500">error</span>
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
