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
        <button @click="tab = 'companion'" :class="tab === 'companion' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2 rounded-xl text-sm font-bold transition-all">AI Voice</button>
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
 
                <div class="pt-6 border-t border-gray-100">
                    <div class="flex items-center justify-between p-6 bg-gray-50 rounded-[2rem] border border-gray-200 transition-all hover:bg-white hover:shadow-xl hover:shadow-gray-200/50 group">
                        <div class="space-y-1">
                            <h4 class="font-black text-gray-900 group-hover:text-primary transition-colors">Enable Web Payment Links</h4>
                            <p class="text-xs font-bold text-gray-500">Allow your digital employee to naturally include payment and upgrade links in conversations when appropriate.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="web_links_enabled" value="1" {{ old('web_links_enabled', $profile->web_links_enabled) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
 
        <!-- Companion Settings -->
        <div x-show="tab === 'companion'" class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100 space-y-6" x-cloak>
            <h3 class="text-xl font-black text-gray-900 mb-2">AI Voice Settings</h3>
            <p class="text-sm text-gray-500 font-medium mb-6">Choose the voice for your daily interactive calls. Your companion's character is fully dynamic and personalized on the fly.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                $voices = [
                    ['id' => 'cgSgspJ2msm6clMCkdW9', 'name' => 'Jessica', 'description' => 'Warm & Friendly Female', 'emoji' => '😊', 'accent' => 'American'],
                    ['id' => 'TX3LPaxmHKxFdv7VOQHJ', 'name' => 'Liam', 'description' => 'Casual & Motivating Male', 'emoji' => '💪', 'accent' => 'American'],
                    ['id' => 'EXAVITQu4vr4xnSDxMaL', 'name' => 'Sarah', 'description' => 'Professional & Clear Female', 'emoji' => '🎯', 'accent' => 'American'],
                    ['id' => 'bIHbv24MWmeRgasZH58o', 'name' => 'Will', 'description' => 'Energetic & Upbeat Male', 'emoji' => '⚡', 'accent' => 'American'],
                    ['id' => 'XB0fDUnXU5powFXDhCwa', 'name' => 'Charlotte', 'description' => 'Calm & Focused Female', 'emoji' => '🧘', 'accent' => 'British'],
                    ['id' => 'nPczCjzI2devNBz1zQrb', 'name' => 'Brian', 'description' => 'Deep & Authoritative Male', 'emoji' => '🦁', 'accent' => 'American'],
                ];
                @endphp

                @foreach($voices as $voice)
                <label class="relative block group cursor-pointer">
                    <input type="radio" name="voice_id" value="{{ $voice['id'] }}" @checked(old('voice_id', $user->voice_id) == $voice['id']) class="peer sr-only">
                    <div class="h-full bg-gray-50 border-2 border-transparent peer-checked:border-primary peer-checked:bg-white rounded-[2rem] p-6 transition-all duration-300 hover:shadow-lg">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="text-3xl w-14 h-14 flex items-center justify-center rounded-2xl bg-white shadow-sm shrink-0 border border-gray-150">{{ $voice['emoji'] }}</div>
                            <div>
                                <h4 class="font-black text-gray-900 flex items-center gap-2">
                                    {{ $voice['name'] }}
                                    <span class="text-[10px] font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">{{ $voice['accent'] }}</span>
                                </h4>
                                <p class="text-xs font-semibold text-primary uppercase tracking-widest mt-1">{{ $voice['description'] }}</p>
                            </div>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Plan & Billing -->
        <div x-show="tab === 'subscription'" class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100 space-y-6" x-cloak>
            <h3 class="text-xl font-black text-gray-900 mb-6">Billing & Credits</h3>
            <div class="bg-primary/5 rounded-[2rem] p-8 border border-primary/10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary text-white rounded-full text-[10px] font-black uppercase tracking-widest mb-3">Prepaid Billing</div>
                        <h4 class="text-2xl font-black text-gray-900">Credits: {{ number_format($user->credits, 2) }}</h4>
                        <p class="text-gray-500 font-medium">You are charged per minute of call time. 1 credit = $1.00.</p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-black text-gray-900">${{ number_format(\App\Models\MonetizationSetting::getInstance()->per_minute_rate, 2) }}<span class="text-sm font-bold text-gray-400">/min</span></p>
                        <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest">per minute rate</p>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-primary/10 flex flex-wrap gap-4">
                    <a href="{{ route('profile.index') }}" class="px-6 py-3 bg-primary text-white font-bold rounded-xl border border-primary shadow-lg shadow-primary/20 hover:bg-primary-container transition-all active:scale-95 text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">add_card</span>
                        Refill Credits
                    </a>
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
