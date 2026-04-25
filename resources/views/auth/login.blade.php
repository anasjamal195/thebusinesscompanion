<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login · Business Companion AI</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 text-gray-900 antialiased">
        <div class="mx-auto mt-20 max-w-md px-4">
            <div class="mb-6 text-center">
                <div class="mx-auto inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                    <span class="text-sm font-semibold">BC</span>
                </div>
                <h1 class="mt-4 text-xl font-semibold">Business Companion AI</h1>
                <p class="mt-1 text-sm text-gray-500">Sign in or create an account to continue.</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex gap-2">
                    <button type="button" class="flex-1 rounded-xl bg-blue-50 px-3 py-2 text-sm font-semibold text-blue-600">Login</button>
                    <button type="button" class="flex-1 rounded-xl px-3 py-2 text-sm font-semibold text-gray-500 hover:bg-gray-50">Sign up</button>
                </div>

                <form class="mt-6 space-y-4">
                    <div class="hidden">
                        <label class="text-sm font-medium text-gray-900">Name</label>
                        <input class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Your name" />
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Email</label>
                        <input type="email" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="you@company.com" />
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Password</label>
                        <input type="password" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="••••••••" />
                    </div>

                    <x-button class="w-full justify-center" href="{{ url('/onboarding/role') }}">Continue</x-button>

                    <p class="text-center text-sm text-gray-500">
                        Don’t have an account?
                        <a href="#" class="font-semibold text-blue-600 hover:text-blue-700">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>

