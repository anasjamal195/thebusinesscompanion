@extends('layouts.onboarding', ['step' => 6])

@section('content')
<div class="h-[calc(100vh-200px)] flex flex-col overflow-hidden animate-in fade-in duration-700">
    
    {{-- ══════════════════════════════════════════
         PHASE 1 — WAITING
         ══════════════════════════════════════════ --}}
    <div id="phase-waiting" class="flex-grow flex flex-col items-center justify-center space-y-12 py-6">
        {{-- Companion avatar --}}
        <div class="text-center space-y-6">
            <div class="relative inline-block">
                <div class="absolute -inset-6 bg-primary/20 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
                <img src="{{ $companion->avatar_url }}" alt="{{ $companion->name }}"
                     class="relative w-32 h-32 rounded-[2rem] object-cover border-4 border-white shadow-2xl">
                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-amber-400 border-4 border-white rounded-full flex items-center justify-center shadow-lg animate-bounce">
                    <span class="material-symbols-outlined text-white text-lg">phone_forwarded</span>
                </div>
            </div>

            <div class="space-y-2">
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">
                    {{ $companion->name }} is calling you…
                </h1>
                <p class="text-lg text-slate-500 max-w-xl mx-auto font-medium">
                    @if($type === 'web')
                        Starting your in-browser voice session in <span id="countdown" class="font-black text-primary">5</span> seconds.
                    @else
                        Your phone will ring in a moment. Pick up to start setup.
                    @endif
                </p>
            </div>
        </div>

        {{-- Status badge + retry --}}
        <div class="flex flex-col items-center gap-5">
            <div id="badge-waiting" class="flex items-center gap-3 px-6 py-3 bg-slate-900 text-white rounded-full text-sm font-bold tracking-widest uppercase">
                <span class="w-2 h-2 bg-amber-400 rounded-full animate-ping"></span>
                Preparing Session…
            </div>

            <form action="{{ route('onboarding.retry_call') }}" method="POST">
                @csrf
                <button type="submit"
                        class="text-slate-400 hover:text-primary transition-colors font-bold text-xs uppercase tracking-widest flex items-center gap-2 group">
                    <span class="material-symbols-outlined text-[18px] group-hover:rotate-180 transition-transform duration-500">refresh</span>
                    Retry connection
                </button>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         PHASE 2 — CALLING (Integrated)
         ══════════════════════════════════════════ --}}
    <div id="phase-calling" class="hidden flex-grow flex flex-col md:flex-row gap-8 py-6 h-full overflow-hidden">
        
        {{-- Left: Call Status & Controls --}}
        <div class="w-full md:w-1/2 flex flex-col items-center justify-center space-y-8 bg-slate-900 rounded-[3rem] p-10 text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-primary/20 to-slate-900 opacity-50"></div>
            
            <div class="relative z-10 space-y-6">
                <div class="relative inline-block">
                    <div class="absolute -inset-4 bg-primary/30 rounded-full blur-2xl animate-pulse"></div>
                    <img src="{{ $companion->avatar_url }}" alt="{{ $companion->name }}"
                         class="relative w-32 h-32 rounded-[2rem] object-cover border-4 border-white/20 shadow-2xl">
                    <span class="absolute -bottom-1 -right-1 flex h-6 w-6">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-6 w-6 bg-green-500 border-2 border-white"></span>
                    </span>
                </div>

                <div>
                    <h2 class="text-2xl font-black text-white">{{ $companion->name }}</h2>
                    <p class="text-white/60 text-sm font-medium">On call with you</p>
                </div>

                <div class="text-5xl font-black text-white tracking-widest font-mono" id="call-timer">0:00</div>

                <div class="flex items-center justify-center gap-4 pt-4">
                    <button id="btn-mute" class="w-16 h-16 bg-white/10 hover:bg-white/20 text-white rounded-2xl flex items-center justify-center transition-all active:scale-90 border border-white/10 backdrop-blur-md">
                        <span class="material-symbols-outlined text-3xl">mic</span>
                    </button>
                    <button id="btn-end-call" class="px-10 h-16 bg-red-500 hover:bg-red-600 text-white font-black rounded-2xl flex items-center gap-3 transition-all active:scale-95 shadow-xl shadow-red-500/20">
                        <span class="material-symbols-outlined text-2xl">call_end</span>
                        End Call
                    </button>
                </div>
            </div>
        </div>

        {{-- Right: Live Capture --}}
        <div class="w-full md:w-1/2 flex flex-col bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between shrink-0">
                <h3 class="font-black text-slate-900 text-sm uppercase tracking-widest">Real-time Data Capture</h3>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-[10px] font-black text-slate-400 uppercase">Live Sync</span>
                </div>
            </div>
            
            <div class="flex-grow overflow-y-auto p-6 space-y-3 scrollbar-thin">
                @php
                    $liveFields = [
                        'business_type' => ['Type', 'business'],
                        'industry'      => ['Industry', 'factory'],
                        'target_audience' => ['Audience', 'groups'],
                        'experience_level' => ['Experience', 'trending_up'],
                        'project_name'  => ['Project', 'folder_open'],
                        'first_task'    => ['First Task', 'task_alt'],
                    ];
                @endphp

                @foreach($liveFields as $key => [$label, $icon])
                <div id="live-{{ $key }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-slate-50 opacity-40 transition-all duration-500">
                    <div class="live-icon w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 shrink-0">
                        <span class="material-symbols-outlined text-base">{{ $icon }}</span>
                    </div>
                    <div class="min-w-0">
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $label }}</div>
                        <div class="live-value text-sm text-slate-400 italic truncate">Waiting…</div>
                    </div>
                    <span class="live-check ml-auto shrink-0 text-green-500 hidden">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                    </span>
                </div>
                @endforeach
            </div>
            
            <div class="p-6 bg-slate-50/50 text-center shrink-0">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Speak naturally, I'm listening...</p>
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════
     PHASE 3 — PROCESSING OVERLAY
     ══════════════════════════════════════════ --}}
<div id="phase-processing" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md">
    <div class="w-full max-w-sm mx-4 bg-white rounded-[3rem] shadow-2xl p-12 text-center space-y-8">
        <div class="relative w-24 h-24 mx-auto">
            <div class="absolute -inset-4 bg-primary/20 rounded-full blur-2xl animate-pulse"></div>
            <div class="relative w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center">
                <svg class="w-12 h-12 text-primary animate-spin" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
        
        <div class="space-y-2">
            <h2 class="text-2xl font-black text-slate-900">Crafting your workspace</h2>
            <p class="text-slate-500 font-medium">Sit tight, your companion is organizing everything you discussed.</p>
        </div>

        <div class="space-y-3">
            <div id="process-step-extract" class="flex items-center gap-3 text-slate-400 transition-colors">
                <span class="material-symbols-outlined text-xl">pending</span>
                <span class="text-sm font-bold">Extracting business profile</span>
            </div>
            <div id="process-step-project" class="flex items-center gap-3 text-slate-400 transition-colors">
                <span class="material-symbols-outlined text-xl">pending</span>
                <span class="text-sm font-bold">Initializing first project</span>
            </div>
            <div id="process-step-task" class="flex items-center gap-3 text-slate-400 transition-colors">
                <span class="material-symbols-outlined text-xl">pending</span>
                <span class="text-sm font-bold">Generating action items</span>
            </div>
        </div>
    </div>
</div>

<script type="module">
    import Vapi from 'https://esm.sh/@vapi-ai/web@latest';
    window.Vapi = Vapi;
    window.dispatchEvent(new Event('vapi-ready'));
</script>
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script>
document.addEventListener('vapi-ready', () => initVapi());
document.addEventListener('DOMContentLoaded', () => { if (window.Vapi) initVapi(); });

let vapiInstance = null;
let isProcessingShown = false;

function initVapi() {
    if (vapiInstance) return;
    
    const userId          = {{ auth()->id() }};
    const callType        = '{{ $type }}';
    const vapiPublicKey   = '{{ $vapiPublicKey }}';
    const assistantId     = '{{ $assistantId }}';
    const dynamicPrompt   = {!! json_encode($dynamicPrompt) !!};
    
    const phaseWaiting    = document.getElementById('phase-waiting');
    const phaseCalling    = document.getElementById('phase-calling');
    const phaseProcessing = document.getElementById('phase-processing');
    const timerEl         = document.getElementById('call-timer');

    if (callType === 'web' && vapiPublicKey && window.Vapi) {
        vapiInstance = new window.Vapi(vapiPublicKey);
        
        vapiInstance.on('call-start', () => {
            console.log('[Vapi Web] Call started');
            showCalling();
        });

        vapiInstance.on('call-end', () => {
            console.log('[Vapi Web] Call ended');
            showProcessing();
        });

        vapiInstance.on('error', (e) => {
            console.error('[Vapi Web] Error:', e);
            alert('Could not start web call. Check mic permissions.');
        });

        // Controls
        const btnMute = document.getElementById('btn-mute');
        const btnEnd  = document.getElementById('btn-end-call');
        let isMuted   = false;

        if (btnMute) {
            btnMute.addEventListener('click', () => {
                isMuted = !isMuted;
                vapiInstance.setMuted(isMuted);
                btnMute.querySelector('.material-symbols-outlined').textContent = isMuted ? 'mic_off' : 'mic';
                btnMute.classList.toggle('bg-red-500/20', isMuted);
                btnMute.classList.toggle('text-red-500', isMuted);
            });
        }

        if (btnEnd) {
            btnEnd.addEventListener('click', () => {
                showProcessing();
                try { vapiInstance.stop(); } catch(e) {}
            });
        }
    }

    // ── Countdown ───────────────────────────────────────────
    let seconds = 5;
    const countdownEl = document.getElementById('countdown');
    if (countdownEl) {
        const interval = setInterval(() => {
            seconds--;
            countdownEl.innerText = seconds;
            if (seconds <= 0) {
                clearInterval(interval);
                if (callType === 'web' && vapiInstance) {
                    const assistant = {
                        id: assistantId,
                        model: {
                            messages: [{ role: 'system', content: dynamicPrompt }]
                        }
                    };
                    console.log('[Vapi Web] Starting with assistant object:', assistant);
                    vapiInstance.start(assistant);
                }
            }
        }, 1000);
    }

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

    function showCalling() {
        phaseWaiting.classList.add('hidden');
        phaseCalling.classList.remove('hidden');
        startTimer();
    }

    function showProcessing() {
        if (isProcessingShown) return;
        isProcessingShown = true;
        clearInterval(timerInterval);
        phaseCalling.classList.add('hidden');
        phaseProcessing.classList.remove('hidden');
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
    }

    // ── Pusher ───────────────────────────────────────────────
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        wsHost: '{{ config('broadcasting.connections.pusher.options.host') }}',
        wsPort: {{ config('broadcasting.connections.pusher.options.port', 80) }},
        wssPort: {{ config('broadcasting.connections.pusher.options.port', 443) }},
        forceTLS: {{ config('broadcasting.connections.pusher.options.useTLS') ? 'true' : 'false' }},
        enabledTransports: ['ws', 'wss'],
        channelAuthorization: {
            endpoint: '/broadcasting/auth',
            headers: { 'X-CSRF-Token': '{{ csrf_token() }}' }
        }
    });

    const channel = pusher.subscribe('private-user.' + userId);
    channel.bind('call.progress', (data) => {
        if (data.field === 'call_started') showCalling();
        else if (data.field === 'complete') {
            window.location.href = data.value;
        } else if (data.field === 'call_ended') {
            showProcessing();
        } else {
            updateLiveField(data.field, data.value);
        }
    });
}
</script>

<style>
.scrollbar-thin::-webkit-scrollbar { width: 4px; }
.scrollbar-thin::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 99px; }
body { overflow: hidden; }
</style>
@endsection
