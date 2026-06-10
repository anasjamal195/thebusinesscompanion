@php
    $title = 'Settings';
    $pageTitle = 'Settings';
    $activeNav = 'settings';
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="{ tab: 'general' }">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-900">Settings</h2>
        @if(session('success'))
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
    </div>

    {{-- Tabs --}}
    <div class="flex gap-1 p-1 bg-gray-100 rounded-lg w-fit flex-wrap">
        <button @click="tab = 'general'" :class="tab === 'general' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-md text-sm font-medium transition-all">General</button>
        <button @click="tab = 'calling'" :class="tab === 'calling' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-md text-sm font-medium transition-all">Calling</button>
        <button @click="tab = 'companion'" :class="tab === 'companion' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-md text-sm font-medium transition-all">AI Voice</button>
        <button @click="tab = 'billing'" :class="tab === 'billing' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-md text-sm font-medium transition-all">Billing</button>
    </div>

    <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
        @csrf

        {{-- General Tab --}}
        <div x-show="tab === 'general'" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5">
            <h3 class="text-base font-semibold text-gray-900">General Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-medium text-gray-500">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-medium text-gray-500">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm">
                </div>
            </div>
        </div>

        {{-- Calling Tab --}}
        <div x-show="tab === 'calling'" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5" x-cloak>
            <h3 class="text-base font-semibold text-gray-900">Calling Preferences</h3>

            {{-- Calling Preference --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-2">Receive calls via</label>
                <div class="flex gap-2">
                    <label class="flex-1 flex items-center gap-3 p-3 rounded-lg border cursor-pointer transition-colors
                          {{ old('calling_preference', $user->calling_preference ?? 'app') === 'app' ? 'border-primary bg-primary/5' : 'border-gray-200 bg-gray-50 hover:bg-gray-100' }}">
                        <input type="radio" name="calling_preference" value="app" class="sr-only"
                               {{ old('calling_preference', $user->calling_preference ?? 'app') === 'app' ? 'checked' : '' }}>
                        <span class="material-symbols-outlined text-[22px] {{ old('calling_preference', $user->calling_preference ?? 'app') === 'app' ? 'text-primary' : 'text-gray-400' }}">globe</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">In-Browser App</p>
                            <p class="text-[11px] text-gray-400">Call via your browser</p>
                        </div>
                    </label>
                    <label class="flex-1 flex items-center gap-3 p-3 rounded-lg border cursor-pointer transition-colors
                          {{ old('calling_preference', $user->calling_preference ?? 'app') === 'phone' ? 'border-primary bg-primary/5' : 'border-gray-200 bg-gray-50 hover:bg-gray-100' }}">
                        <input type="radio" name="calling_preference" value="phone" class="sr-only"
                               {{ old('calling_preference', $user->calling_preference ?? 'app') === 'phone' ? 'checked' : '' }}>
                        <span class="material-symbols-outlined text-[22px] {{ old('calling_preference', $user->calling_preference ?? 'app') === 'phone' ? 'text-primary' : 'text-gray-400' }}">phone_in_talk</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Phone Number</p>
                            <p class="text-[11px] text-gray-400">Call via your phone</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Phone Number --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1.5">Phone Number</label>
                <p class="text-xs text-gray-400 mb-2">Only US numbers supported. Required if "Phone Number" is selected above.</p>
                <div class="flex rounded-lg border border-gray-200 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20 bg-gray-50 overflow-hidden">
                    <span class="inline-flex items-center px-3 text-sm font-medium text-gray-500 bg-gray-100 border-r border-gray-200 select-none">+1</span>
                    <input type="text" name="phone_number_display" id="phone_number_display"
                           value="{{ old('phone_number') ? substr(old('phone_number'), 2) : ($profile->phone_number ? substr($profile->phone_number, 2) : '') }}"
                           placeholder="(234) 567 8900" maxlength="14"
                           class="flex-1 border-0 focus:ring-0 bg-transparent py-2 px-3 text-sm">
                    <input type="hidden" name="phone_number" id="phone_number"
                           value="{{ old('phone_number', $profile->phone_number ?? '') }}">
                </div>
                @error('phone_number')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-gray-100">

            {{-- Morning Call Time --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1.5">Morning Call Time</label>
                <input type="time" name="morning_call_time" value="{{ old('morning_call_time', $user->morning_call_time ?? '09:00') }}"
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm">
            </div>

            {{-- Timezone --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1.5">Timezone</label>
                <select name="timezone" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm">
                    @foreach (timezone_identifiers_list() as $tz)
                        <option value="{{ $tz }}" {{ old('timezone', $user->timezone ?? 'UTC') === $tz ? 'selected' : '' }}>{{ $tz }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Follow-up Interval --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1.5">
                    Follow-up Interval <span class="text-gray-400 font-normal">(Optional)</span>
                </label>
                <p class="text-xs text-gray-400 mb-2">Gap between follow-up calls. Leave blank for AI to estimate.</p>
                <div class="relative">
                    <input type="number" name="default_delay_minutes"
                           value="{{ old('default_delay_minutes', $user->default_delay_minutes) }}"
                           min="1" placeholder="e.g. 120"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm pr-20">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium pointer-events-none">minutes</span>
                </div>
            </div>
        </div>

        {{-- AI Voice Tab --}}
        <div x-show="tab === 'companion'" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5" x-cloak>
            <div>
                <h3 class="text-base font-semibold text-gray-900">AI Voice Settings</h3>
                <p class="text-sm text-gray-500 mt-1">Choose the voice for your daily calls.</p>
            </div>

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
                <div class="voice-card cursor-pointer rounded-lg border-2 p-3.5 flex items-center gap-3 transition-all duration-200 hover:border-primary hover:bg-primary/5 {{ $selectedVoice === $voice['id'] ? 'border-primary bg-primary/5' : 'border-gray-100 bg-gray-50' }}"
                     data-voice-id="{{ $voice['id'] }}"
                     onclick="selectVoice('{{ $voice['id'] }}', this)">
                    <span class="text-2xl w-10 h-10 flex items-center justify-center rounded-lg bg-white shadow-sm shrink-0">{{ $voice['emoji'] }}</span>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900 flex items-center gap-2">
                            {{ $voice['name'] }}
                            <span class="text-[10px] font-medium text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">{{ $voice['accent'] }}</span>
                        </div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $voice['description'] }}</div>
                    </div>
                    <div class="voice-check shrink-0 w-4 h-4 rounded-full border-2 transition-all {{ $selectedVoice === $voice['id'] ? 'border-primary bg-primary' : 'border-gray-300' }} flex items-center justify-center">
                        <svg class="w-2.5 h-2.5 text-white {{ $selectedVoice === $voice['id'] ? '' : 'hidden' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                @endforeach
            </div>

            @error('voice_id')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <script>
            function selectVoice(voiceId, el) {
                document.querySelectorAll('.voice-card').forEach(card => {
                    card.classList.remove('border-primary', 'bg-primary/5');
                    card.classList.add('border-gray-100', 'bg-gray-50');
                    const check = card.querySelector('.voice-check');
                    check.classList.remove('border-primary', 'bg-primary');
                    check.classList.add('border-gray-300');
                    check.querySelector('svg').classList.add('hidden');
                });
                el.classList.add('border-primary', 'bg-primary/5');
                el.classList.remove('border-gray-100', 'bg-gray-50');
                const check = el.querySelector('.voice-check');
                check.classList.add('border-primary', 'bg-primary');
                check.classList.remove('border-gray-300');
                check.querySelector('svg').classList.remove('hidden');
                document.getElementById('voice_id').value = voiceId;
            }
            </script>
        </div>

        {{-- Billing Tab --}}
        <div x-show="tab === 'billing'" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5" x-cloak>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Billing & Credits</h3>
                <p class="text-sm text-gray-500 mt-1">Manage your credits and view usage.</p>
            </div>
            <div class="bg-primary/5 rounded-xl p-6 border border-primary/10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-primary text-white rounded-md text-[10px] font-semibold uppercase tracking-wider mb-2">Prepaid</div>
                        <h4 class="text-xl font-bold text-gray-900">{{ number_format($user->credits, 2) }} credits</h4>
                        <p class="text-sm text-gray-500">1 credit = $1.00 &middot; Charged per minute of call time.</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-gray-900">${{ number_format(\App\Models\MonetizationSetting::getInstance()->per_minute_rate, 2) }}<span class="text-xs font-medium text-gray-400">/min</span></p>
                        <p class="text-[11px] font-medium text-gray-400 tracking-wider">PER MINUTE RATE</p>
                    </div>
                </div>
                <div class="mt-5 pt-5 border-t border-primary/10 flex gap-3">
                    <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add_card</span>
                        Refill Credits
                    </a>
                </div>
            </div>
        </div>

        {{-- Save Bar --}}
        <div class="sticky bottom-6 bg-white/90 backdrop-blur-md rounded-xl border border-gray-200 shadow-lg p-4 flex items-center justify-between gap-4 z-40">
            <p class="hidden md:block text-sm text-gray-500">Unsaved changes will be lost.</p>
            <button type="submit" class="w-full md:w-auto px-6 py-2.5 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Save Settings
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Phone number formatting
    const display = document.getElementById('phone_number_display');
    const hidden = document.getElementById('phone_number');
    if (display && hidden) {
        display.addEventListener('input', function () {
            let val = this.value.replace(/\D/g, '');
            if (val.length > 10) val = val.slice(0, 10);
            let formatted = '';
            if (val.length > 0) {
                if (val.length <= 3) {
                    formatted = val;
                } else if (val.length <= 6) {
                    formatted = '(' + val.slice(0, 3) + ') ' + val.slice(3);
                } else {
                    formatted = '(' + val.slice(0, 3) + ') ' + val.slice(3, 6) + ' ' + val.slice(6);
                }
            }
            this.value = formatted;
            hidden.value = val ? '+1' + val : '';
        });
    }
});
</script>
@endsection
