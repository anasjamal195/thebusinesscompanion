<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign up · The Business Companion AI</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 text-gray-900 antialiased">
        <div class="mx-auto mt-20 max-w-md px-4">
            <div class="mb-6 text-center">
                <div class="mx-auto inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                    <span class="text-sm font-semibold">TBC</span>
                </div>
                <h1 class="mt-4 text-xl font-semibold">Create your account</h1>
                <p class="mt-1 text-sm text-gray-500">Start onboarding and generate your first report.</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="text-sm font-medium text-gray-900">Name</label>
                        <input name="name" type="text" value="{{ old('name') }}" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Your name" required />
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="you@company.com" required />
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Password</label>
                        <input name="password" type="password" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="••••••••" required />
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Confirm password</label>
                        <input name="password_confirmation" type="password" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="••••••••" required />
                    </div>

                    <x-button type="submit" class="w-full justify-center">Create account</x-button>

                    <p class="text-center text-sm text-gray-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">Sign in</a>
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>

