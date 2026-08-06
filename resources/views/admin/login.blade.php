<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Admin Login · {{ config('app.name', 'dialer.best') }}</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#0B1020] text-white antialiased font-sans">
        <div class="relative min-h-screen flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_-20%,rgba(99,102,241,0.35),transparent_55%)]" aria-hidden="true"></div>

            <div class="relative w-full max-w-sm">
                <div class="mb-8 text-center">
                    <div class="mx-auto inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-primary text-white shadow-lg shadow-primary/30">
                        <span class="material-symbols-outlined text-[26px]">shield</span>
                    </div>
                    <h1 class="mt-4 text-2xl font-bold tracking-tight">Admin Panel</h1>
                    <p class="mt-1 text-sm text-gray-400">Restricted area — authorized personnel only.</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl shadow-2xl">
                    <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="text-sm font-medium text-gray-300">Email</label>
                            <input name="email" type="email" value="{{ old('email') }}" autofocus required
                                placeholder="admin@goalchaser.co"
                                class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-primary focus:ring-primary focus:outline-none" />
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-300">Password</label>
                            <input name="password" type="password" required
                                placeholder="••••••••"
                                class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-primary focus:ring-primary focus:outline-none" />
                        </div>

                        @error('email')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        <button type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all">
                            <span class="material-symbols-outlined text-[18px]">lock</span>
                            Sign in to Admin
                        </button>
                    </form>
                </div>

                <p class="mt-6 text-center text-xs text-gray-500">
                    Not an admin? <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-primary/80">Back to app login</a>
                </p>
            </div>
        </div>
    </body>
</html>