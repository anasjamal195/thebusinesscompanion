@extends('layouts.onboarding', ['step' => 6])

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="text-center space-y-4">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">How would you like to onboard?</h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto">Choose your preferred method to complete the setup process with your new companion.</p>
    </div>

    <form action="{{ route('onboarding.method.save') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Call Onboarding (Disabled/Coming Soon or just interactive) -->
            <label class="relative group cursor-not-allowed">
                <input type="radio" name="method" value="call" class="peer sr-only" disabled>
                <div class="h-full p-8 bg-white border-2 border-slate-100 rounded-[3rem] shadow-sm flex flex-col gap-6 opacity-60 grayscale">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400">
                        <span class="material-symbols-outlined text-4xl">phone_callback</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <h3 class="text-2xl font-black text-slate-900">Onboard through a call</h3>
                            <span class="px-2 py-0.5 bg-slate-100 text-[10px] font-bold text-slate-400 rounded-md uppercase tracking-wide">Coming Soon</span>
                        </div>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Jump on a 5-minute call with your companion. Speak naturally about your business, and they'll handle all the configuration for you.
                        </p>
                    </div>
                </div>
            </label>

            <!-- Platform Onboarding -->
            <label class="relative group cursor-pointer">
                <input type="radio" name="method" value="platform" class="peer sr-only" checked>
                <div class="h-full p-8 bg-white border-2 border-slate-100 rounded-[3rem] shadow-sm transition-all duration-300 group-hover:border-primary/30 group-hover:shadow-xl peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:shadow-primary/10 flex flex-col gap-6">
                    <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary transition-colors group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-4xl">dashboard_customize</span>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-2xl font-black text-slate-900">Onboard through platform</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Continue through our structured digital flow. Provide specific details about your industry, target audience, and current challenges.
                        </p>
                    </div>
                    <div class="mt-auto pt-4 flex items-center gap-2 text-primary font-bold text-sm">
                        <span>Recommended for accuracy</span>
                        <span class="material-symbols-outlined text-[18px]">verified</span>
                    </div>

                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center scale-0 transition-transform duration-300 peer-checked:scale-100 shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-[20px] font-bold">check</span>
                    </div>
                </div>
            </label>
        </div>

        <div class="mt-12 flex justify-center">
            <button type="submit" class="group px-16 py-5 bg-primary hover:bg-primary-container text-white font-black text-xl rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 flex items-center gap-3">
                Continue with Platform flow
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </div>
    </form>
</div>
@endsection
