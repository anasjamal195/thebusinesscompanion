<x-layouts.app :title="__('Sign up')">
    <div class="mx-auto max-w-md">
        <h1 class="text-2xl font-semibold tracking-tight">Create your account</h1>
        <p class="mt-2 text-sm text-white/60">Get access to your dashboard and AI tools.</p>

        <form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-white/80" for="name">Name</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    autocomplete="name"
                    value="{{ old('name') }}"
                    required
                    class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 outline-none ring-0 focus:border-emerald-400/40 focus:bg-white/10"
                    placeholder="Your name"
                />
                @error('name')
                    <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-white/80" for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    value="{{ old('email') }}"
                    required
                    class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 outline-none ring-0 focus:border-emerald-400/40 focus:bg-white/10"
                    placeholder="you@company.com"
                />
                @error('email')
                    <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-white/80" for="password">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    required
                    class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 outline-none ring-0 focus:border-emerald-400/40 focus:bg-white/10"
                    placeholder="At least 8 characters"
                />
                @error('password')
                    <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-white/80" for="password_confirmation">Confirm password</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    required
                    class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 outline-none ring-0 focus:border-emerald-400/40 focus:bg-white/10"
                    placeholder="Repeat password"
                />
            </div>

            <button
                type="submit"
                class="w-full rounded-xl bg-emerald-400 px-4 py-3 text-sm font-semibold text-zinc-950 hover:bg-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-400/40"
            >
                Create account
            </button>

            <p class="text-sm text-white/60">
                Already have an account?
                <a class="text-white underline decoration-white/30 underline-offset-4 hover:decoration-white/60" href="{{ route('login') }}">Sign in</a>
            </p>
        </form>
    </div>
</x-layouts.app>

