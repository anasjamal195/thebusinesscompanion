@extends('layouts.onboarding', ['step' => 2])

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="text-center space-y-4">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Hire your expert companion</h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto">Selected based on your role as a <span class="text-primary font-bold">{{ Session::get('onboarding.role') }}</span>. Each companion comes with a dedicated cloud environment.</p>
    </div>

    <form action="{{ route('onboarding.companion.save') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" x-data="{ selected: '' }">
            @foreach($companions as $companion)
            <label class="relative cursor-pointer group">
                <input type="radio" name="companion_id" value="{{ $companion->id }}" class="peer sr-only" @click="selected = '{{ $companion->id }}'" required>
                <div class="h-full bg-white border-2 border-slate-100 rounded-[2.5rem] p-8 shadow-sm transition-all duration-300 group-hover:border-primary/30 group-hover:shadow-lg peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:shadow-primary/10 flex flex-col gap-6">
                    <div class="relative w-24 h-24 mx-auto">
                        <img src="{{ $companion->avatar_url ?? 'https://i.pravatar.cc/150?u='.$companion->key }}" alt="{{ $companion->name }}" class="w-full h-full rounded-3xl object-cover border-4 border-white shadow-xl shadow-slate-200 group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 border-4 border-white rounded-full flex items-center justify-center">
                            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                        </div>
                    </div>
                    
                    <div class="text-center space-y-2">
                        <h3 class="text-2xl font-black text-slate-900">{{ $companion->name }}</h3>
                        <p class="text-sm font-bold text-primary uppercase tracking-widest">{{ $companion->occupation }} Expert</p>
                    </div>

                    <p class="text-slate-500 text-sm leading-relaxed text-center line-clamp-3">
                        {{ $companion->bio }}
                    </p>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-center gap-2">
                        <span class="text-2xl font-black text-slate-900">${{ number_format($companion->monthly_price, 2) }}</span>
                        <span class="text-slate-400 text-sm">/month</span>
                    </div>

                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center scale-0 transition-transform duration-300 peer-checked:scale-100 shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-[20px] font-bold">check</span>
                    </div>
                </div>
            </label>
            @endforeach
        </div>

        <div class="mt-12 flex flex-col items-center gap-6">
            <button type="submit" class="group px-12 py-5 bg-primary hover:bg-primary-container text-white font-bold text-lg rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
                Continue to Checkout
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">shopping_cart_checkout</span>
            </button>
            <a href="{{ route('onboarding.role') }}" class="text-slate-400 hover:text-slate-600 transition-colors font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Back to role selection
            </a>
        </div>
    </form>
</div>
@endsection
