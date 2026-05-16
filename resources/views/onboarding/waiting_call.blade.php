@extends('layouts.onboarding', ['step' => 6])

@section('content')

{{-- ══════════════════════════════════════════
     PHASE 1 — WAITING (call not yet started)
     ══════════════════════════════════════════ --}}
<div id="phase-waiting" class="max-w-4xl mx-auto space-y-12 py-12 animate-in fade-in slide-in-from-bottom-8 duration-700">

    {{-- Companion avatar --}}
    <div class="text-center space-y-6">
        <div class="relative inline-block">
            <div class="absolute -inset-6 bg-primary/20 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
            <img src="{{ $companion->avatar_url }}" alt="{{ $companion->name }}"
                 class="relative w-36 h-36 rounded-[2rem] object-cover border-4 border-white shadow-2xl">
            <div class="absolute -bottom-2 -right-2 w-11 h-11 bg-amber-400 border-4 border-white rounded-full flex items-center justify-center shadow-lg animate-bounce">
                <span class="material-symbols-outlined text-white text-xl">phone_forwarded</span>
            </div>
        </div>

        <div class="space-y-3">
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">
                {{ $companion->name }} is calling you…
            </h1>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto font-medium">
                Your phone will ring in a moment. Pick up and your companion will guide you through setup.
            </p>
        </div>
    </div>

    {{-- Tip cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        @foreach([
            ['record_voice_over', 'Be Descriptive',    'The more detail you share, the better your workspace will be tailored.'],
            ['timer',             '~&nbsp;5 Minutes',  'A quick introductory call to configure your entire workspace.'],
            ['auto_awesome',      'Auto Setup',        'Your profile, first project, and first task are created automatically.'],
        ] as [$icon, $title, $desc])
        <div class="bg-white/60 backdrop-blur-xl p-8 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col items-center text-center gap-4">
            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-3xl">{{ $icon }}</span>
            </div>
            <div class="space-y-1">
                <h3 class="font-bold text-slate-900">{!! $title !!}</h3>
                <p class="text-sm text-slate-500">{{ $desc }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Status badge + retry --}}
    <div class="flex flex-col items-center gap-5">
        <div id="badge-waiting" class="flex items-center gap-3 px-6 py-3 bg-slate-900 text-white rounded-full text-sm font-bold tracking-widest">
            <span class="w-2 h-2 bg-amber-400 rounded-full animate-ping"></span>
            PREPARING YOUR CALL…
        </div>

        <form action="{{ route('onboarding.retry_call') }}" method="POST">
            @csrf
            <button type="submit"
                    class="text-slate-400 hover:text-primary transition-colors font-bold text-xs uppercase tracking-widest flex items-center gap-2 group">
                <span class="material-symbols-outlined text-[18px] group-hover:rotate-180 transition-transform duration-500">refresh</span>
                Didn't receive a call? Retry
            </button>
        </form>
    </div>
</div>


{{-- ══════════════════════════════════════════
     PHASE 2 — CALLING OVERLAY (call is live)
     ══════════════════════════════════════════ --}}
<div id="phase-calling"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md"
     style="animation: fadeIn .4s ease both;">

    <div class="w-full max-w-lg mx-4 bg-white rounded-[3rem] shadow-2xl overflow-hidden">

        {{-- Gradient header --}}
        <div class="relative bg-gradient-to-br from-slate-900 via-primary/90 to-primary px-8 pt-10 pb-16 text-center overflow-hidden">
            {{-- Animated rings --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-64 h-64 rounded-full border border-white/10 animate-ping" style="animation-duration:2s;"></div>
            </div>
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-44 h-44 rounded-full border border-white/15 animate-ping" style="animation-duration:2.6s;"></div>
            </div>

            {{-- Avatar --}}
            <div class="relative inline-block mb-4">
                <div class="absolute -inset-3 bg-white/10 rounded-full blur-xl animate-pulse"></div>
                <img src="{{ $companion->avatar_url }}" alt="{{ $companion->name }}"
                     class="relative w-24 h-24 rounded-[1.5rem] object-cover border-4 border-white/30 shadow-xl">
                <span class="absolute -bottom-1 -right-1 flex h-5 w-5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-5 w-5 bg-green-500 border-2 border-white"></span>
                </span>
            </div>

            <h2 class="text-2xl font-black text-white">{{ $companion->name }}</h2>
            <p class="text-white/60 text-sm font-medium mt-1">On call with you now</p>

            {{-- Live timer --}}
            <div class="mt-4 text-4xl font-black text-white tracking-widest font-mono" id="call-timer">0:00</div>
        </div>

        {{-- Live data capture --}}
        <div class="-mt-8 mx-6 bg-white rounded-[2rem] shadow-lg border border-slate-100 p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-50">
                <h3 class="font-black text-slate-900 text-sm uppercase tracking-widest">Live Capture</h3>
                <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-full uppercase tracking-widest animate-pulse">
                    Recording
                </span>
            </div>

            @php
                $liveFields = [
                    'business_type'          => ['Business Type',       'business'],
                    'industry'               => ['Industry',            'factory'],
                    'target_audience'        => ['Target Audience',     'groups'],
                    'experience_level'       => ['Experience Level',    'psychology'],
                    'project_name'           => ['First Project',       'rocket_launch'],
                    'project_description'    => ['Project Description', 'description'],
                    'first_task'             => ['First Task',          'task_alt'],
                    'call_followup_preference' => ['Follow-up',         'phone_callback'],
                ];
            @endphp

            <div class="space-y-3 max-h-64 overflow-y-auto pr-1 scrollbar-thin">
                @foreach($liveFields as $key => [$label, $icon])
                <div id="live-{{ $key }}"
                     class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-slate-50 opacity-40 transition-all duration-500">
                    <div class="live-icon w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 shrink-0 transition-all duration-300">
                        <span class="material-symbols-outlined text-lg">{{ $icon }}</span>
                    </div>
                    <div class="min-w-0">
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $label }}</div>
                        <div class="live-value text-sm text-slate-400 italic truncate">Waiting…</div>
                    </div>
                    <span class="live-check ml-auto shrink-0 text-green-500 hidden">
                        <span class="material-symbols-outlined text-xl">check_circle</span>
                    </span>
                </div>
                @endforeach
            </div>

            <p class="text-center text-xs text-slate-400 pt-2">
                Fields are captured automatically as you speak. Do not close this page.
            </p>
        </div>

        <div class="px-8 pb-8 pt-4 text-center">
            <p class="text-slate-400 text-xs">When the call ends, your workspace will be created automatically.</p>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════
     PHASE 3 — PROCESSING OVERLAY (after call ends)
     ══════════════════════════════════════════ --}}
<div id="phase-processing"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md">

    <div class="w-full max-w-sm mx-4 bg-white rounded-[3rem] shadow-2xl p-12 text-center space-y-6">
        <div class="relative w-20 h-20 mx-auto">
            <div class="absolute inset-0 bg-primary/20 rounded-full blur-xl animate-pulse"></div>
            <div class="relative w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center">
                <svg class="w-10 h-10 text-primary animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4z"></path>
                </svg>
            </div>
        </div>

        <div class="space-y-2">
            <h2 class="text-2xl font-black text-slate-900">Building your workspace…</h2>
            <p class="text-slate-500 text-sm leading-relaxed">
                We're analysing your conversation and creating your first project and task. This takes about 30 seconds.
            </p>
        </div>

        <div class="space-y-2 text-left">
            @foreach([
                ['check_circle', 'Call completed & saved',     true],
                ['pending',      'Extracting business details', false, 'process-step-extract'],
                ['pending',      'Creating your first project', false, 'process-step-project'],
                ['pending',      'Dispatching first task',      false, 'process-step-task'],
            ] as $step)
            <div @if(isset($step[3])) id="{{ $step[3] }}" @endif
                 class="flex items-center gap-3 px-4 py-2 rounded-xl {{ $step[2] ? 'text-green-600' : 'text-slate-400' }}">
                <span class="material-symbols-outlined text-xl">{{ $step[0] }}</span>
                <span class="text-sm font-semibold">{{ $step[1] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════ --}}
{{-- Vapi Web SDK --}}
<script src="https://cdn.jsdelivr.net/npm/@vapi-ai/web@latest/dist/vapi.js"></script>
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Check if Vapi is available globally from the JSDelivr bundle
    const VapiConstructor = window.Vapi;
    
    if (!VapiConstructor) {
        console.error('Vapi SDK failed to load. Please check the network tab.');
    }
    
    const userId          = {{ auth()->id() }};
    const callType        = '{{ $type }}';
    const vapiPublicKey   = '{{ $vapiPublicKey }}';
    const assistantId     = '{{ $assistantId }}';
    
    const phaseWaiting    = document.getElementById('phase-waiting');
    const phaseCalling    = document.getElementById('phase-calling');
    const phaseProcessing = document.getElementById('phase-processing');
    const timerEl         = document.getElementById('call-timer');

    let vapi = null;
    if (callType === 'web' && vapiPublicKey && VapiConstructor) {
        vapi = new VapiConstructor(vapiPublicKey);
        
        vapi.on('call-start', () => {
            console.log('[Vapi Web] Call started');
            showCalling();
        });

        vapi.on('call-end', () => {
            console.log('[Vapi Web] Call ended');
            showProcessing();
        });

        vapi.on('message', (message) => {
            if (message.type === 'tool-calls') {
                // We handle data capture via WebSockets from the backend for consistency
                // but we could also handle it here if the tool was client-side.
            }
        });

        vapi.on('error', (e) => {
            console.error('[Vapi Web] Error:', e);
            alert('Could not start web call. Please check your microphone permissions.');
        });
    }

    // ── Countdown for auto-start ────────────────────────────
    let seconds = 5;
    const countdownEl = document.getElementById('countdown');
    
    const interval = setInterval(() => {
        seconds--;
        if (countdownEl) countdownEl.innerText = seconds;
        
        if (seconds <= 0) {
            clearInterval(interval);
            if (callType === 'web' && vapi) {
                console.log('[Vapi Web] Auto-starting call...');
                vapi.start(assistantId, {
                    variableValues: {
                        user_name: '{{ auth()->user()->name }}',
                        user_role: '{{ auth()->user()->role ?? "Founder" }}'
                    }
                });
            }
        }
    }, 1000);

    // ── Timer ───────────────────────────────────────────────
    let timerInterval = null;
    let callSeconds   = 0;
    function startTimer() {
        callSeconds = 0;
        timerInterval = setInterval(() => {
            callSeconds++;
            const m = Math.floor(callSeconds / 60);
            const s = String(callSeconds % 60).padStart(2, '0');
            timerEl.textContent = `${m}:${s}`;
        }, 1000);
    }
    function stopTimer() {
        clearInterval(timerInterval);
    }

    // ── Phase transitions ────────────────────────────────────
    function showCalling() {
        phaseWaiting.classList.add('hidden');
        phaseCalling.classList.remove('hidden');
        startTimer();
    }
    function showProcessing() {
        stopTimer();
        phaseCalling.classList.add('hidden');
        phaseProcessing.classList.remove('hidden');
        // Animate processing steps
        setTimeout(() => animateStep('process-step-extract', 'autorenew'), 1500);
        setTimeout(() => animateStep('process-step-project', 'pending'),   4000);
        setTimeout(() => animateStep('process-step-task',    'pending'),   7000);
    }
    function animateStep(id, icon) {
        const el = document.getElementById(id);
        if (!el) return;
        el.querySelector('.material-symbols-outlined').textContent = 'autorenew';
        el.classList.replace('text-slate-400', 'text-primary');
        el.querySelector('.material-symbols-outlined').classList.add('animate-spin');
    }

    // ── Live field update ────────────────────────────────────
    function updateLiveField(field, value) {
        const row = document.getElementById('live-' + field);
        if (!row) return;

        row.classList.remove('opacity-40');
        row.classList.add('bg-green-50', '!opacity-100');

        const icon = row.querySelector('.live-icon');
        icon.classList.replace('bg-slate-100', 'bg-green-100');
        icon.classList.replace('text-slate-400', 'text-green-600');

        row.querySelector('.live-value').textContent = value;
        row.querySelector('.live-value').classList.replace('text-slate-400', 'text-slate-800');
        row.querySelector('.live-value').classList.remove('italic');

        const check = row.querySelector('.live-check');
        if (check) check.classList.remove('hidden');

        row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // ── Pusher ───────────────────────────────────────────────
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster:          '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        wsHost:           '{{ config('broadcasting.connections.pusher.options.host') }}',
        wsPort:           {{ config('broadcasting.connections.pusher.options.port', 80) }},
        wssPort:          {{ config('broadcasting.connections.pusher.options.port', 443) }},
        forceTLS:         {{ config('broadcasting.connections.pusher.options.useTLS') ? 'true' : 'false' }},
        enabledTransports: ['ws', 'wss'],
        channelAuthorization: {
            endpoint: '/broadcasting/auth',
            headers:  { 'X-CSRF-Token': '{{ csrf_token() }}' }
        }
    });

    const channel = pusher.subscribe('private-user.' + userId);

    channel.bind('call.progress', (data) => {
        console.log('[Vapi WS]', data);

        switch (data.field) {
            // ── Vapi confirmed call is ringing ──
            case 'call_started':
                showCalling();
                break;

            // ── A data field was captured live ──
            case 'business_type':
            case 'industry':
            case 'target_audience':
            case 'experience_level':
            case 'project_name':
            case 'project_description':
            case 'first_task':
            case 'call_followup_preference':
                updateLiveField(data.field, data.value);
                break;

            // ── Call ended → processing started ──
            case 'call_ended':
                showProcessing();
                break;

            // ── Processing complete → redirect to dashboard ──
            case 'complete':
                // Mark all steps done
                ['process-step-extract','process-step-project','process-step-task'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        const ico = el.querySelector('.material-symbols-outlined');
                        ico.textContent = 'check_circle';
                        ico.classList.remove('animate-spin');
                        el.classList.replace('text-primary', 'text-green-600');
                    }
                });
                // Small delay so user sees the ✓ before redirect
                setTimeout(() => {
                    window.location.href = '/projects/' + data.value;
                }, 1800);
                break;
        }
    });

    // Connection feedback
    pusher.connection.bind('connected', () => {
        console.log('[Pusher] Connected ✓');
        const badge = document.getElementById('badge-waiting');
        if (badge) {
            badge.innerHTML = '<span class="w-2 h-2 bg-green-400 rounded-full animate-ping"></span> WAITING FOR CALL…';
        }
    });
});
</script>

<style>
@keyframes fadeIn { from { opacity:0 } to { opacity:1 } }
.scrollbar-thin::-webkit-scrollbar { width: 4px; }
.scrollbar-thin::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 99px; }
</style>
@endsection
