@extends('layouts.onboarding', ['step' => 1])

@section('content')
<div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-slate-100 max-w-2xl mx-auto">
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-3">Set up your daily calls</h1>
        <p class="text-lg text-slate-500">dialer.best will call you every morning, get your tasks, and check in throughout the day.</p>
    </div>

    <form method="POST" action="{{ route('onboarding.schedule.save') }}" class="space-y-8">
        @csrf

        {{-- Morning Call Time --}}
        <div>
            <label for="morning_call_time" class="block text-sm font-semibold text-slate-700 mb-1">Morning Call Time</label>
            <input type="time" name="morning_call_time" id="morning_call_time" value="{{ old('morning_call_time', '09:00') }}" required class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-primary/20 transition-colors bg-slate-50">
            @error('morning_call_time')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Timezone --}}
        <div>
            <label for="timezone" class="block text-sm font-semibold text-slate-700 mb-1">Your Timezone</label>
            <select name="timezone" id="timezone" required class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-primary/20 transition-colors bg-slate-50">
                @foreach (timezone_identifiers_list() as $tz)
                    <option value="{{ $tz }}" {{ old('timezone', 'UTC') === $tz ? 'selected' : '' }}>{{ $tz }}</option>
                @endforeach
            </select>
            @error('timezone')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Follow-up Delay --}}
        <div>
            <label for="default_delay_minutes" class="block text-sm font-semibold text-slate-700 mb-1">
                Follow-up Interval <span class="text-slate-400 font-normal">(Optional)</span>
            </label>
            <p class="text-xs text-slate-500 mb-2">Set a fixed gap between calls (e.g. 120 for every 2 hours: 9am → 11am → 1pm). Leave blank and the AI will estimate based on your task durations.</p>
            <div class="relative">
                <input type="number" name="default_delay_minutes" id="default_delay_minutes" value="{{ old('default_delay_minutes') }}" min="1" placeholder="e.g. 120" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-primary/20 transition-colors bg-slate-50 pr-20">
                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-medium pointer-events-none">minutes</span>
            </div>
            @error('default_delay_minutes')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Phone Number --}}
        <div>
            <label for="phone_number" class="block text-sm font-semibold text-slate-700 mb-1">
                Phone Number <span class="text-slate-400 font-normal">(Optional)</span>
            </label>
            <p class="text-xs text-slate-500 mb-2">Leave blank to use web calls instead.</p>
            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" placeholder="+1 234 567 8900" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-primary/20 transition-colors bg-slate-50">
            @error('phone_number')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Voice Selection --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Choose Your AI Voice</label>
            <p class="text-xs text-slate-500 mb-4">This is who will call you every morning. Pick a voice that feels right.</p>

            <input type="hidden" name="voice_id" id="voice_id" value="{{ old('voice_id', 'cgSgspJ2msm6clMCkdW9') }}">

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
                @endphp

                @foreach($voices as $voice)
                <div class="voice-card cursor-pointer rounded-2xl border-2 p-4 flex items-center gap-4 transition-all duration-200 hover:border-primary hover:bg-primary/5 {{ old('voice_id', 'cgSgspJ2msm6clMCkdW9') === $voice['id'] ? 'border-primary bg-primary/5' : 'border-slate-100 bg-slate-50' }}"
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
                    <div class="voice-check shrink-0 w-5 h-5 rounded-full border-2 transition-all {{ old('voice_id', 'cgSgspJ2msm6clMCkdW9') === $voice['id'] ? 'border-primary bg-primary' : 'border-slate-200' }} flex items-center justify-center">
                        <svg class="w-3 h-3 text-white {{ old('voice_id', 'cgSgspJ2msm6clMCkdW9') === $voice['id'] ? '' : 'hidden' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                @endforeach
            </div>

            @error('voice_id')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-4 px-6 bg-primary text-white font-bold rounded-xl shadow-md shadow-primary/20 hover:opacity-90 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                Complete Setup →
            </button>
        </div>
    </form>
</div>

<script>
function selectVoice(voiceId, el) {
    // Deselect all
    document.querySelectorAll('.voice-card').forEach(card => {
        card.classList.remove('border-primary', 'bg-primary/5');
        card.classList.add('border-slate-100', 'bg-slate-50');
        const check = card.querySelector('.voice-check');
        check.classList.remove('border-primary', 'bg-primary');
        check.classList.add('border-slate-200');
        check.querySelector('svg').classList.add('hidden');
    });

    // Select clicked card
    el.classList.add('border-primary', 'bg-primary/5');
    el.classList.remove('border-slate-100', 'bg-slate-50');
    const check = el.querySelector('.voice-check');
    check.classList.add('border-primary', 'bg-primary');
    check.classList.remove('border-slate-200');
    check.querySelector('svg').classList.remove('hidden');

    // Update hidden input
    document.getElementById('voice_id').value = voiceId;
}
</script>
@endsection
