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
        <button @click="tab = 'companion'" :class="tab === 'companion' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2 rounded-xl text-sm font-bold transition-all">AI Voice</button>
        <button @click="tab = 'subscription'" :class="tab === 'subscription' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2 rounded-xl text-sm font-bold transition-all">Billing</button>
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
 

 
        <!-- Companion Settings -->
        <div x-show="tab === 'companion'" class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100 space-y-6" x-cloak>
            <h3 class="text-xl font-black text-gray-900 mb-2">AI Voice Settings</h3>
            <p class="text-sm text-gray-500 font-medium mb-6">Choose the voice for your daily interactive calls. Your companion's character is fully dynamic and personalized on the fly.</p>

            <input type="hidden" name="voice_id" id="voice_id" value="{{ old('voice_id', $user->voice_id ?? 'cgSgspJ2msm6clMCkdW9') }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="voice-cards">
                @php
                $voices = [
                    ['id' => 'cgSgspJ2msm6clMCkdW9', 'name' => 'Jessica', 'description' => 'Warm & Friendly Female', 'emoji' => '😊', 'accent' => 'American'],
                    ['id' => 'TX3LPaxmHKxFdv7VOQHJ', 'name' => 'Liam', 'description' => 'Casual & Motivating Male', 'emoji' => '💪', 'accent' => 'American'],
                    ['id' => 'EXAVITQu4vr4xnSDxMaL', 'name' => 'Sarah', 'description' => 'Professional & Clear Female', 'emoji' => '🎯', 'accent' => 'American'],
                    ['id' => 'bIHbv24MWmeRgasZH58o', 'name' => 'Will', 'description' => 'Energetic & Upbeat Male', 'emoji' => '⚡', 'accent' => 'American'],
                    ['id' => 'XB0fDUnXU5powFXDhCwa', 'name' => 'Charlotte', 'description' => 'Calm & Focused Female', 'emoji' => '🧘', 'accent' => 'British'],
                    ['id' => 'nPczCjzI2devNBz1zQrb', 'name' => 'Brian', 'description' => 'Deep & Authoritative Male', 'emoji' => '🦁', 'accent' => 'American'],
                ];
                $selectedVoice = old('voice_id', $user->voice_id ?? 'cgSgspJ2msm6clMCkdW9');
                @endphp

                @foreach($voices as $voice)
                <div class="voice-card cursor-pointer rounded-2xl border-2 p-4 flex items-center gap-4 transition-all duration-200 hover:border-primary hover:bg-primary/5 {{ $selectedVoice === $voice['id'] ? 'border-primary bg-primary/5' : 'border-slate-100 bg-slate-50' }}"
                     data-voice-id="{{ $voice['id'] }}"
                     onclick="selectVoice('{{ $voice['id'] }}', this)">
                    <div class="text-3xl w-12 h-12 flex items-center justify-center rounded-xl bg-white shadow-sm shrink-0">{{ $voice['emoji'] }}</div>
                    <div class="flex-grow min-w-0">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            {{ $voice['name'] }}
                            <span class="text-[10px] font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">{{ $voice['accent'] }}</span>
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5">{{ $voice['description'] }}</div>
                    </div>
                    <div class="voice-check shrink-0 w-5 h-5 rounded-full border-2 transition-all {{ $selectedVoice === $voice['id'] ? 'border-primary bg-primary' : 'border-slate-200' }} flex items-center justify-center">
                        <svg class="w-3 h-3 text-white {{ $selectedVoice === $voice['id'] ? '' : 'hidden' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                @endforeach
            </div>

            @error('voice_id')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <script>
        function selectVoice(voiceId, el) {
            document.querySelectorAll('.voice-card').forEach(card => {
                card.classList.remove('border-primary', 'bg-primary/5');
                card.classList.add('border-slate-100', 'bg-slate-50');
                const check = card.querySelector('.voice-check');
                check.classList.remove('border-primary', 'bg-primary');
                check.classList.add('border-slate-200');
                check.querySelector('svg').classList.add('hidden');
            });
            el.classList.add('border-primary', 'bg-primary/5');
            el.classList.remove('border-slate-100', 'bg-slate-50');
            const check = el.querySelector('.voice-check');
            check.classList.add('border-primary', 'bg-primary');
            check.classList.remove('border-slate-200');
            check.querySelector('svg').classList.remove('hidden');
            document.getElementById('voice_id').value = voiceId;
        }
        </script>

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
