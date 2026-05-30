@extends('layouts.onboarding', ['step' => 1])

@section('content')
<div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-slate-100 max-w-2xl mx-auto" x-data="onboardingForm()">
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-3">Set up your daily calls</h1>
        <p class="text-lg text-slate-500">dialer.best will call you every morning, get your tasks, and check in throughout the day.</p>
    </div>

    <form method="POST" action="{{ route('onboarding.schedule.save') }}" class="space-y-8" @@submit.prevent="submitForm">
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
            <p class="text-xs text-slate-500 mb-2">Only <strong>US numbers</strong> are supported at this time. Leave blank to use web calls instead.</p>
            <div class="flex rounded-xl border border-slate-200 focus-within:border-primary focus-within:ring focus-within:ring-primary/20 transition-colors bg-slate-50 overflow-hidden">
                <span class="inline-flex items-center px-3.5 text-sm font-medium text-slate-500 bg-slate-100 border-r border-slate-200 select-none">+1</span>
                <input type="text" name="phone_number_display" id="phone_number_display" value="{{ old('phone_number') ? substr(old('phone_number'), 2) : '' }}" placeholder="(234) 567 8900" maxlength="14" class="flex-1 border-0 focus:ring-0 bg-transparent py-2.5 px-3 text-sm" x-on:input="onPhoneInput" x-on:keydown="onPhoneKeydown">
                <input type="hidden" name="phone_number" id="phone_number" x-model="phoneFull">
            </div>
            <p class="mt-1.5 text-xs text-slate-400" x-show="phoneFull && !phoneError" x-cloak>
                Will be called as <strong x-text="phoneFull"></strong>
            </p>
            <p class="mt-1.5 text-xs text-red-500" x-show="phoneError" x-cloak x-text="phoneError"></p>
            @error('phone_number')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Voice Selection --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Choose Your AI Voice</label>
            <p class="text-xs text-slate-500 mb-4">This is who will call you every morning. Tap the <span class="font-semibold">play</span> button to hear a sample.</p>

            <input type="hidden" name="voice_id" id="voice_id" x-model="selectedVoice">

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
                <div class="voice-card cursor-pointer rounded-2xl border-2 p-4 flex items-center gap-3 transition-all duration-200 hover:border-primary hover:bg-primary/5"
                     :class="selectedVoice === '{{ $voice['id'] }}' ? 'border-primary bg-primary/5' : 'border-slate-100 bg-slate-50'"
                     data-voice-id="{{ $voice['id'] }}"
                     @@click="selectVoice('{{ $voice['id'] }}')">

                    <div class="text-3xl w-12 h-12 flex items-center justify-center rounded-xl bg-white shadow-sm shrink-0">{{ $voice['emoji'] }}</div>

                    <div class="flex-grow min-w-0">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            {{ $voice['name'] }}
                            <span class="text-[10px] font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">{{ $voice['accent'] }}</span>
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5">{{ $voice['description'] }}</div>
                    </div>

                    <div class="flex items-center gap-1">
                        <button type="button" @@click.stop="togglePreview('{{ $voice['id'] }}', '{{ $voice['name'] }}')"
                                class="voice-play-btn w-8 h-8 rounded-full flex items-center justify-center transition-all duration-200 shrink-0"
                                :class="playing === '{{ $voice['id'] }}' ? 'bg-primary text-white shadow-sm' : 'bg-slate-100 text-slate-400 hover:bg-slate-200 hover:text-slate-600'"
                                :title="playing === '{{ $voice['id'] }}' ? 'Stop' : 'Play sample'">
                            <template x-if="playing !== '{{ $voice['id'] }}'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </template>
                            <template x-if="playing === '{{ $voice['id'] }}'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                            </template>
                        </button>

                        <div class="voice-check shrink-0 w-5 h-5 rounded-full border-2 transition-all flex items-center justify-center"
                             :class="selectedVoice === '{{ $voice['id'] }}' ? 'border-primary bg-primary' : 'border-slate-200'">
                            <svg class="w-3 h-3 text-white" :class="selectedVoice === '{{ $voice['id'] }}' ? '' : 'hidden'" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
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

    {{-- Non-US Coming Soon Modal --}}
    <div x-show="showNonUsModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @@click="showNonUsModal = false"></div>
        <div class="relative bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="scale-95 opacity-0 translate-y-4"
             x-transition:enter-end="scale-100 opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="scale-100 opacity-100 translate-y-0"
             x-transition:leave-end="scale-95 opacity-0 translate-y-4">
            <div class="text-center">
                <div class="mx-auto w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Coming Soon</h3>
                <p class="text-sm text-slate-500 mb-6">
                    We currently support <strong>US phone numbers</strong> only. International VOIP support is on our roadmap and will be available soon!
                </p>
                <div class="flex flex-col gap-3">
                    <button type="button" @@click="showNonUsModal = false; clearPhone()" class="w-full py-3 px-4 bg-primary text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-200">
                        Use Web Calls Instead
                    </button>
                    <button type="button" @@click="showNonUsModal = false" class="w-full py-3 px-4 bg-slate-50 text-slate-600 font-medium rounded-xl border border-slate-200 hover:bg-slate-100 transition-all duration-200">
                        Enter a US Number
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function onboardingForm() {
    return {
        selectedVoice: '{{ old('voice_id', 'cgSgspJ2msm6clMCkdW9') }}',
        playing: null,
        synth: window.speechSynthesis,
        utterance: null,
        phoneFull: '',
        phoneError: '',
        showNonUsModal: false,
        nonUsAttempt: '',

        selectVoice(voiceId) {
            this.selectedVoice = voiceId;
            document.getElementById('voice_id').value = voiceId;
        },

        togglePreview(voiceId, voiceName) {
            if (this.playing === voiceId) {
                this.stopPreview();
                return;
            }
            this.stopPreview();
            this.playing = voiceId;
            this.synth.cancel();

            const sampleText = `Hi, I'm ${voiceName}. Let me help you run your business today.`;
            this.utterance = new SpeechSynthesisUtterance(sampleText);

            const voices = this.synth.getVoices();
            const preferred = voices.find(v =>
                voiceName === 'Jessica' || voiceName === 'Sarah' || voiceName === 'Charlotte'
                    ? v.name.toLowerCase().includes('female')
                    : v.name.toLowerCase().includes('male')
            );
            if (preferred) this.utterance.voice = preferred;

            this.utterance.rate = 1.0;
            this.utterance.pitch = 1.0;
            this.utterance.volume = 1.0;

            this.utterance.onend = () => { this.playing = null; };
            this.utterance.onerror = () => { this.playing = null; };

            this.synth.speak(this.utterance);
        },

        stopPreview() {
            this.synth.cancel();
            this.playing = null;
            this.utterance = null;
        },

        onPhoneInput(e) {
            const raw = e.target.value;
            this.phoneError = '';
            this.showNonUsModal = false;

            if (raw.includes('+')) {
                const ccMatch = raw.match(/\+(\d+)/);
                if (ccMatch && ccMatch[1] !== '1') {
                    this.nonUsAttempt = raw;
                    this.showNonUsModal = true;
                    e.target.value = '';
                    this.phoneFull = '';
                    return;
                }
                const stripped = raw.replace(/^\+1/, '');
                const digits = stripped.replace(/[^0-9]/g, '').slice(0, 10);
                const formatted = this.formatPhone(digits);
                e.target.value = formatted;
                this.phoneFull = digits ? '+1' + digits : '';
                this.phoneError = digits.length > 0 && digits.length < 10 ? 'Please enter a complete 10-digit US number.' : '';
                return;
            }

            const digits = raw.replace(/[^0-9]/g, '').slice(0, 10);
            if (!digits) {
                this.phoneFull = '';
                e.target.value = '';
                return;
            }

            const formatted = this.formatPhone(digits);
            e.target.value = formatted;
            this.phoneFull = '+1' + digits;

            if (digits.length < 10) {
                this.phoneError = 'Please enter a complete 10-digit US number.';
            } else {
                this.phoneError = '';
            }
        },

        onPhoneKeydown(e) {
            if (e.key === 'Backspace' || e.key === 'Delete') return;
            if (e.key === 'v' && (e.ctrlKey || e.metaKey)) {
                setTimeout(() => this.onPhoneInput(e), 50);
            }
        },

        formatPhone(digits) {
            if (digits.length <= 3) return digits;
            if (digits.length <= 6) return `(${digits.slice(0, 3)}) ${digits.slice(3)}`;
            return `(${digits.slice(0, 3)}) ${digits.slice(3, 6)} ${digits.slice(6)}`;
        },

        clearPhone() {
            this.phoneFull = '';
            this.phoneError = '';
            document.getElementById('phone_number_display').value = '';
        },

        submitForm(e) {
            if (this.phoneFull && this.phoneFull.length < 12) {
                this.phoneError = 'Please enter a complete 10-digit US number.';
                e.preventDefault();
                return;
            }
            e.target.submit();
        }
    };
}

document.addEventListener('DOMContentLoaded', () => {
    window.speechSynthesis.getVoices();
});
</script>
@endsection
