@php
    $title = 'Settings';
    $pageTitle = 'Settings';
    $activeNav = 'settings';
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="{ tab: 'general' }">
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Settings</h2>
        @if(session('success'))
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-xl text-sm font-bold border border-green-100">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- Tabs Nav -->
    <div class="flex p-1.5 bg-gray-100 rounded-2xl w-fit">
        <button @click="tab = 'general'" :class="tab === 'general' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2 rounded-xl text-sm font-bold transition-all">General</button>
        <button @click="tab = 'business'" :class="tab === 'business' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2 rounded-xl text-sm font-bold transition-all">Business</button>
        <button @click="tab = 'companion'" :class="tab === 'companion' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2 rounded-xl text-sm font-bold transition-all">Companion</button>
        <button @click="tab = 'subscription'" :class="tab === 'subscription' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2 rounded-xl text-sm font-bold transition-all">Plan & Billing</button>
    </div>

    <form action="{{ route('settings.update') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- General Settings -->
        <div x-show="tab === 'general'" class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100 space-y-6">
            <h3 class="text-xl font-black text-gray-900 mb-6">General Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-semibold">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-semibold">
                </div>
            </div>
        </div>

        <!-- Business Settings -->
        <div x-show="tab === 'business'" class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100 space-y-6" x-cloak>
            <h3 class="text-xl font-black text-gray-900 mb-6">Business Details</h3>
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Business Name</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $profile->business_name) }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-semibold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Website URL</label>
                        <input type="url" name="business_url" value="{{ old('business_url', $profile->business_url) }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-semibold">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Industry</label>
                    <input type="text" name="industry" value="{{ old('industry', $profile->industry) }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-semibold">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Describe your Business</label>
                    <textarea name="business_description" rows="4" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-semibold">{{ old('business_description', $profile->business_description) }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Current Challenges & Pain Points</label>
                        <textarea name="current_problems" rows="4" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-semibold">{{ old('current_problems', $profile->current_problems) }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Most Urgent Task</label>
                        <textarea name="urgent_tasks" rows="4" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-semibold">{{ old('urgent_tasks', $profile->urgent_tasks) }}</textarea>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Experience Level</label>
                    <select name="experience_level" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-semibold appearance-none">
                        <option value="beginner" @selected(old('experience_level', $profile->experience_level) == 'beginner')>Beginner</option>
                        <option value="intermediate" @selected(old('experience_level', $profile->experience_level) == 'intermediate')>Intermediate</option>
                        <option value="expert" @selected(old('experience_level', $profile->experience_level) == 'expert')>Expert</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Companion Settings -->
        <div x-show="tab === 'companion'" class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100 space-y-6" x-cloak>
            <h3 class="text-xl font-black text-gray-900 mb-6">Digital Employee</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($companions as $companion)
                <label class="relative block group cursor-pointer">
                    <input type="radio" name="companion_id" value="{{ $companion->id }}" @checked(old('companion_id', $user->companion_id) == $companion->id) class="peer sr-only">
                    <div class="h-full bg-gray-50 border-2 border-transparent peer-checked:border-primary peer-checked:bg-white rounded-[2rem] p-6 transition-all duration-300 hover:shadow-lg">
                        <div class="flex items-center gap-4 mb-4">
                            <img src="{{ $companion->avatar_url }}" class="w-16 h-16 rounded-2xl object-cover grayscale group-hover:grayscale-0 transition-all peer-checked:grayscale-0">
                            <div>
                                <h4 class="font-black text-gray-900">{{ $companion->name }}</h4>
                                <p class="text-xs font-bold text-primary uppercase tracking-widest">{{ $companion->occupation }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 font-medium leading-relaxed">{{ $companion->tagline }}</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Plan & Billing -->
        <div x-show="tab === 'subscription'" class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100 space-y-6" x-cloak>
            <h3 class="text-xl font-black text-gray-900 mb-6">Plan & Billing</h3>
            <div class="bg-primary/5 rounded-[2rem] p-8 border border-primary/10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary text-white rounded-full text-[10px] font-black uppercase tracking-widest mb-3">Active Plan</div>
                        <h4 class="text-2xl font-black text-gray-900">Business Pro</h4>
                        <p class="text-gray-500 font-medium">Full access to autonomous cloud computer & voice calls.</p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-black text-gray-900">$49<span class="text-sm font-bold text-gray-400">/mo</span></p>
                        <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest">Next payment: May 15, 2026</p>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-primary/10 flex flex-wrap gap-4">
                    <a href="#" class="px-6 py-3 bg-white text-gray-900 font-bold rounded-xl border border-gray-200 shadow-sm hover:bg-gray-50 transition-all active:scale-95 text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                        Billing Portal (Stripe)
                    </a>
                    <button type="button" class="px-6 py-3 bg-red-50 text-red-600 font-bold rounded-xl border border-red-100 hover:bg-red-100 transition-all active:scale-95 text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                        Cancel Subscription
                    </button>
                </div>
            </div>
        </div>

        <!-- Submit Bar -->
        <div class="sticky bottom-8 bg-white/80 backdrop-blur-md rounded-[2rem] p-4 border border-gray-200 shadow-2xl flex items-center justify-between gap-8 z-40">
            <p class="hidden md:block pl-4 text-sm font-medium text-gray-500">Unsaved changes will be lost if you leave without saving.</p>
            <button type="submit" class="w-full md:w-auto px-12 py-4 bg-primary hover:bg-primary-container text-white font-black text-lg rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                Save Settings
                <span class="material-symbols-outlined font-bold text-2xl">save</span>
            </button>
        </div>
    </form>
</div>
@endsection
