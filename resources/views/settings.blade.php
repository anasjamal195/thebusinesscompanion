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
    <div class="flex gap-1 p-1 bg-gray-100 rounded-lg w-fit">
        <button @click="tab = 'general'" :class="tab === 'general' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-md text-sm font-medium transition-all">General</button>
        <button @click="tab = 'community'" :class="tab === 'community' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 rounded-md text-sm font-medium transition-all">Community</button>
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

        {{-- Community Tab --}}
        <div x-show="tab === 'community'" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5" x-cloak>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Community Participation</h3>
                <p class="text-sm text-gray-500 mt-1">Choose how you participate. Your activity data remains private by default.</p>
            </div>

            <div class="space-y-3">
                @php $mode = old('community_participation_mode', $user->community_participation_mode ?? 'private'); @endphp
                @foreach ([
                    ['value' => 'private', 'icon' => 'lock', 'title' => 'Private Mode', 'desc' => 'Your activity stays private. Achievements earned internally. Nothing visible to others.'],
                    ['value' => 'social', 'icon' => 'public', 'title' => 'Social Mode', 'desc' => 'Share achievements and interact with the community. Follow others and see progress.'],
                    ['value' => 'hybrid', 'icon' => 'manage_accounts', 'title' => 'Hybrid Mode', 'desc' => 'Selectively share individual achievements. Best of both worlds.', 'recommended' => true],
                ] as $option)
                <label class="block cursor-pointer">
                    <div class="flex items-center gap-3 p-4 rounded-lg border transition-all duration-200 {{ $mode === $option['value'] ? 'border-primary bg-primary/5' : 'border-gray-100 bg-gray-50 hover:border-gray-200' }}">
                        <span class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[20px]">{{ $option['icon'] }}</span>
                        </span>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-900">{{ $option['title'] }}</span>
                                @if(!empty($option['recommended']))
                                    <span class="text-[10px] font-semibold text-green-600 bg-green-100 px-1.5 py-0.5 rounded-md uppercase">Recommended</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $option['desc'] }}</p>
                        </div>
                        <div class="shrink-0">
                            <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center {{ $mode === $option['value'] ? 'border-primary bg-primary' : 'border-gray-300' }}">
                                @if($mode === $option['value'])
                                    <span class="material-symbols-outlined text-[12px] text-white font-bold">check</span>
                                @endif
                            </div>
                        </div>
                        <input type="radio" name="community_participation_mode" value="{{ $option['value'] }}" class="absolute inset-0 opacity-0 cursor-pointer" {{ $mode === $option['value'] ? 'checked' : '' }}>
                    </div>
                </label>
                @endforeach
            </div>
            <input type="hidden" name="community_participation_mode" id="community_mode" value="{{ $mode }}">
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

    <script>
    document.querySelectorAll('input[name="community_participation_mode"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('community_mode').value = this.value;
        });
    });
    </script>
</div>
@endsection
