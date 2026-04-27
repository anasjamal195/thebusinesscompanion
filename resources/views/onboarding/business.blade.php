@extends('layouts.onboarding', ['step' => 4])

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="text-center space-y-4">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Business Profile</h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto">Set up your workspace. This helps your companion understand your business context from day one.</p>
    </div>

    <div class="bg-white rounded-[3rem] p-8 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100">
        <form action="{{ route('onboarding.business.save') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="business_name" class="block text-sm font-bold text-slate-700 ml-1">Company Name</label>
                    <input type="text" name="business_name" id="business_name" value="{{ old('business_name', auth()->user()->profile->business_name ?? '') }}" required placeholder="Acme Corp"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300">
                </div>

                <div class="space-y-2">
                    <label for="business_url" class="block text-sm font-bold text-slate-700 ml-1">Website URL</label>
                    <input type="url" name="business_url" id="business_url" value="{{ old('business_url', auth()->user()->profile->business_url ?? '') }}" placeholder="https://acme.com"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300">
                </div>
            </div>

            <div class="space-y-2">
                <label for="business_description" class="block text-sm font-bold text-slate-700 ml-1">Business Description</label>
                <textarea name="business_description" id="business_description" rows="4" required placeholder="Briefly describe what your business does, your mission, and your core products or services..."
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300">{{ old('business_description', auth()->user()->profile->business_description ?? '') }}</textarea>
            </div>

            <div class="pt-4 flex justify-between items-center">
                <div class="flex items-center gap-2 text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">verified_user</span>
                    <span class="text-sm">Information remains private</span>
                </div>
                <button type="submit" class="group px-12 py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
                    Next: Calling Setup
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">headset_mic</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
