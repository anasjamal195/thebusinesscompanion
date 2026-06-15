<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin' }} — {{ config('app.name', 'dialer.best') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        [x-cloak] {
            display: none !important;
        }
        .scrollbar-thin::-webkit-scrollbar { width: 4px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 99px; }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
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
        <aside class="fixed inset-y-0 left-0 z-30 w-60 flex-col border-r border-gray-200 bg-white hidden lg:flex">
            <div class="flex h-14 items-center gap-2.5 px-5 border-b border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-white shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">shield</span>
                    </span>
                    <div class="leading-tight">
                        <div class="text-sm font-bold text-gray-900 tracking-tight">Admin</div>
                        <div class="text-[9px] font-semibold text-primary uppercase tracking-[0.2em]">Panel</div>
                    </div>
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto scrollbar-thin px-3 py-4 space-y-0.5">
                @php
                    $navItems = [
                        ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'grid_view', 'route' => 'admin.dashboard'],
                        ['key' => 'users', 'label' => 'Users', 'icon' => 'group', 'route' => 'admin.users.index'],
                        ['key' => 'calls', 'label' => 'Calls', 'icon' => 'history', 'route' => 'admin.calls.index'],
                        ['key' => 'payments', 'label' => 'Payments', 'icon' => 'payments', 'route' => 'admin.payments.index'],
                        ['key' => 'monetization', 'label' => 'Monetization', 'icon' => 'tune', 'route' => 'admin.monetization.index'],
                        ['key' => 'waitlist', 'label' => 'Waitlist', 'icon' => 'list_alt', 'route' => 'admin.waitlist.index'],
                        ['key' => 'inquiries', 'label' => 'Inquiries', 'icon' => 'contact_mail', 'route' => 'admin.inquiries.index'],
                    ];
                    $currentKey = $activeNav ?? 'dashboard';
                @endphp

                @foreach ($navItems as $item)
                    @php $isActive = $currentKey === $item['key']; @endphp
                    <a href="{{ route($item['route']) }}"
                        class="{{ $isActive ? 'bg-primary/10 text-primary font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 font-medium' }} group flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm transition-all duration-150">
                        <span class="material-symbols-outlined text-[20px]">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-gray-100 p-3">
                <div class="flex items-center gap-2.5 px-2 py-2">
                    <div class="h-8 w-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-semibold text-xs shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                        <div class="text-[11px] text-gray-400">Admin</div>
                    </div>
                </div>
                <div class="mt-1 flex items-center gap-1">
                    <a href="{{ route('dashboard') }}" class="flex-1 flex items-center justify-center gap-1.5 rounded-lg py-2 text-xs font-medium text-gray-500 hover:bg-gray-100 transition-all">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                        App
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-1.5 rounded-lg py-2 px-3 text-xs font-medium text-gray-500 hover:bg-red-50 hover:text-red-500 transition-all">
                            <span class="material-symbols-outlined text-[16px]">logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-h-screen lg:pl-60">
            <header class="sticky top-0 z-20 border-b border-gray-200 bg-white/90 backdrop-blur-md">
                <div class="flex items-center justify-between gap-4 px-6 h-14">
                    <h1 class="truncate text-lg font-bold text-gray-900 tracking-tight">{{ $pageTitle ?? ($title ?? 'Admin Dashboard') }}</h1>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                        Back to App
                    </a>
                </div>
            </header>

            <main class="flex-1 px-6 py-6">
                <div class="max-w-7xl mx-auto">
                    @if (session('success'))
                        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm font-medium text-green-700 flex items-center gap-2">
                            <span class="material-symbols-outlined text-green-500">check_circle</span>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm font-medium text-red-700 flex items-center gap-2">
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
