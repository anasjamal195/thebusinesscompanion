@extends('layouts.onboarding', ['step' => 3])

@section('content')
<div class="max-w-2xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="text-center space-y-4">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Create your account</h1>
        <p class="text-lg text-slate-500">Secure your digital partner and start your journey.</p>
    </div>

    <!-- Companion Card Summary -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 flex items-center gap-6 shadow-sm">
        <img src="{{ $companion->avatar_url ?? 'https://i.pravatar.cc/150?u='.$companion->key }}" alt="{{ $companion->name }}" class="w-20 h-20 rounded-2xl object-cover border-2 border-slate-50">
        <div class="flex-grow">
            <h3 class="text-xl font-bold text-slate-900">{{ $companion->name }}</h3>
            <p class="text-sm text-slate-500">{{ $companion->occupation }} Specialist</p>
        </div>
        <div class="text-right">
            <p class="text-2xl font-black text-slate-900">${{ number_format($companion->monthly_price, 2) }}</p>
            <p class="text-xs text-slate-400">per month</p>
        </div>
    </div>

    <div class="bg-white rounded-[3rem] p-8 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100">
        <form action="{{ route('onboarding.processCheckout') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label for="name" class="block text-sm font-bold text-slate-700 ml-1">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="John Doe"
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300 @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label for="email" class="block text-sm font-bold text-slate-700 ml-1">Business Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="john@company.com"
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300 @error('email') border-red-500 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-bold text-slate-700 ml-1">Password</label>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300 @error('password') border-red-500 @enderror">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 ml-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-primary hover:bg-primary-container text-white font-black text-xl rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                    Proceed to Payment
                    <span class="material-symbols-outlined font-bold">arrow_forward</span>
                </button>
            </div>
            
            <p class="text-center text-xs text-slate-400 px-8">
                By creating an account, you agree to our <a href="#" class="text-primary hover:underline">Terms of Service</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a>.
            </p>
        </form>
    </div>

    <div class="flex justify-center">
        <a href="{{ route('onboarding.companion') }}" class="text-slate-400 hover:text-slate-600 transition-colors font-medium flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Back to companion choice
        </a>
    </div>
</div>
@endsection
