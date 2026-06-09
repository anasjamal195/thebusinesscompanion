@extends('layouts.onboarding', ['step' => 1])

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8" x-data="onboardingForm()">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary/10 text-primary mb-4">
            <span class="material-symbols-outlined text-[28px]">call_made</span>
        </div>
        <h1 class="text-xl font-bold text-gray-900 mb-2">Set up your daily calls</h1>
        <p class="text-sm text-gray-500">We'll call you every morning, track your tasks, and keep you accountable throughout the day.</p>
    </div>

    <form method="POST" action="{{ route('onboarding.schedule.save') }}" class="space-y-6">
        @csrf

        {{-- Morning Call Time --}}
        <div>
            <label for="morning_call_time" class="block text-sm font-medium text-gray-700 mb-1.5">Morning Call Time</label>
            <input type="time" name="morning_call_time" id="morning_call_time" value="{{ old('morning_call_time', '09:00') }}" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-gray-50">
            @error('morning_call_time')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Timezone --}}
        <div>
            <label for="timezone" class="block text-sm font-medium text-gray-700 mb-1.5">Your Timezone</label>
            <select name="timezone" id="timezone" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-gray-50">
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
            <label for="default_delay_minutes" class="block text-sm font-medium text-gray-700 mb-1.5">
                Follow-up Interval <span class="text-gray-400 font-normal">(Optional)</span>
            </label>
            <p class="text-xs text-gray-500 mb-2">Set a fixed gap between calls (e.g., 120 for every 2 hours). Leave blank for AI to estimate based on tasks.</p>
            <div class="relative">
                <input type="number" name="default_delay_minutes" id="default_delay_minutes" value="{{ old('default_delay_minutes') }}" min="1" placeholder="e.g. 120" class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-gray-50 pr-20">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium pointer-events-none">minutes</span>
            </div>
            @error('default_delay_minutes')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Phone Number --}}
        <div>
            <label for="phone_number_display" class="block text-sm font-medium text-gray-700 mb-1.5">
                Phone Number <span class="text-gray-400 font-normal">(Optional)</span>
            </label>
            <p class="text-xs text-gray-500 mb-2">Only <strong>US numbers</strong> supported. Leave blank for web calls.</p>
            <div class="flex rounded-lg border border-gray-200 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20 bg-gray-50 overflow-hidden">
                <span class="inline-flex items-center px-3 text-sm font-medium text-gray-500 bg-gray-100 border-r border-gray-200 select-none">+1</span>
                <input type="text" name="phone_number_display" id="phone_number_display" value="{{ old('phone_number') ? substr(old('phone_number'), 2) : '' }}" placeholder="(234) 567 8900" maxlength="14" class="flex-1 border-0 focus:ring-0 bg-transparent py-2 px-3 text-sm">
                <input type="hidden" name="phone_number" id="phone_number" value="{{ old('phone_number', '') }}">
            </div>
            @error('phone_number')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Voice Selection --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Choose Your AI Voice</label>
            <p class="text-xs text-gray-500 mb-4">This is who will call you every morning.</p>

            <input type="hidden" name="voice_id" id="voice_id" x-model="selectedVoice">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                @php
                $voices = [
                    ['id' => 'cgSgspJ2msm6clMCkdW9', 'name' => 'Jessica', 'description' => 'Warm & Friendly', 'emoji' => '😊'],
                    ['id' => 'TX3LPaxmHKxFdv7VOQHJ', 'name' => 'Liam', 'description' => 'Casual & Motivating', 'emoji' => '💪'],
                    ['id' => 'EXAVITQu4vr4xnSDxMaL', 'name' => 'Sarah', 'description' => 'Professional & Clear', 'emoji' => '🎯'],
                    ['id' => 'bIHbv24MWmeRgasZH58o', 'name' => 'Will', 'description' => 'Energetic & Upbeat', 'emoji' => '⚡'],
                    ['id' => 'XB0fDUnXU5powFXDhCwa', 'name' => 'Charlotte', 'description' => 'Calm & Focused', 'emoji' => '🧘'],
                    ['id' => 'nPczCjzI2devNBz1zQrb', 'name' => 'Brian', 'description' => 'Deep & Authoritative', 'emoji' => '🦁'],
                ];
                @endphp

                @foreach($voices as $voice)
                <div class="voice-card cursor-pointer rounded-lg border-2 p-3.5 flex items-center gap-3 transition-all duration-200 hover:border-primary hover:bg-primary/5"
                     :class="selectedVoice === '{{ $voice['id'] }}' ? 'border-primary bg-primary/5' : 'border-gray-100 bg-gray-50'"
                     data-voice-id="{{ $voice['id'] }}"
                     @click="selectedVoice = '{{ $voice['id'] }}'">

                    <span class="text-2xl w-10 h-10 flex items-center justify-center rounded-lg bg-white shadow-sm shrink-0">{{ $voice['emoji'] }}</span>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900">{{ $voice['name'] }}</div>
                        <div class="text-xs text-gray-500">{{ $voice['description'] }}</div>
                    </div>
                    <div class="voice-check shrink-0 w-4 h-4 rounded-full border-2 transition-all flex items-center justify-center"
                         :class="selectedVoice === '{{ $voice['id'] }}' ? 'border-primary bg-primary' : 'border-gray-300'">
                        <svg class="w-2.5 h-2.5 text-white" :class="selectedVoice === '{{ $voice['id'] }}' ? '' : 'hidden'" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                @endforeach
            </div>

            @error('voice_id')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-3 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                Complete Setup →
            </button>
        </div>
    </form>
</div>

<script>
function onboardingForm() {
    return {
        selectedVoice: '{{ old('voice_id', 'cgSgspJ2msm6clMCkdW9') }}',
    };
}
</script>
@endsection
