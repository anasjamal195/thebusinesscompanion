@extends('layouts.onboarding', ['step' => 6])

@section('content')
<div class="max-w-4xl mx-auto space-y-12 py-12 animate-in fade-in slide-in-from-bottom-8 duration-1000">
    <div class="text-center space-y-6">
        <div class="relative inline-block">
            <div class="absolute -inset-4 bg-primary/20 rounded-full blur-2xl animate-pulse"></div>
            <img src="{{ $companion->avatar_url }}" alt="{{ $companion->name }}" class="relative w-32 h-32 rounded-[2rem] object-cover border-4 border-white shadow-2xl">
            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-green-500 border-4 border-white rounded-full flex items-center justify-center shadow-lg">
                <span class="material-symbols-outlined text-white text-xl animate-bounce">phone_in_talk</span>
            </div>
        </div>
        
        <div class="space-y-4">
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">
                {{ $companion->name }} is calling...
            </h1>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto font-medium">
                Please have your phone ready. We'll be connected in exactly <span id="countdown" class="text-primary font-black">5</span> seconds.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white/50 backdrop-blur-xl p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col items-center text-center gap-4">
            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-3xl">record_voice_over</span>
            </div>
            <div class="space-y-1">
                <h3 class="font-bold text-slate-900">Be Descriptive</h3>
                <p class="text-sm text-slate-500">The more details you provide, the better I can assist you.</p>
            </div>
        </div>

        <div class="bg-white/50 backdrop-blur-xl p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col items-center text-center gap-4">
            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-3xl">timer</span>
            </div>
            <div class="space-y-1">
                <h3 class="font-bold text-slate-900">~ 5 Minutes</h3>
                <p class="text-sm text-slate-500">It's a quick introductory call to set up your workspace.</p>
            </div>
        </div>

        <div class="bg-white/50 backdrop-blur-xl p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col items-center text-center gap-4">
            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-3xl">auto_awesome</span>
            </div>
            <div class="space-y-1">
                <h3 class="font-bold text-slate-900">Automatic Setup</h3>
                <p class="text-sm text-slate-500">I'll automatically update your profile based on our chat.</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center gap-6">
        <div id="connection-status" class="flex items-center gap-4 px-6 py-3 bg-slate-900 text-white rounded-full text-sm font-bold tracking-wide">
            <span class="w-2 h-2 bg-green-400 rounded-full animate-ping"></span>
            WAITING FOR CONNECTION...
        </div>

        <form action="{{ route('onboarding.retry_call') }}" method="POST">
            @csrf
            <button type="submit" class="text-slate-400 hover:text-primary transition-colors font-bold text-xs uppercase tracking-widest flex items-center gap-2 group">
                <span class="material-symbols-outlined text-[18px] group-hover:rotate-180 transition-transform duration-500">refresh</span>
                Didn't receive a call? Retry
            </button>
        </form>
    </div>

    <!-- Live Progress Tracking -->
    <div id="onboarding-progress" class="max-w-2xl mx-auto w-full bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl space-y-8 hidden">
        <div class="flex items-center justify-between border-b border-slate-50 pb-6">
            <h2 class="text-2xl font-black text-slate-900">Live Onboarding</h2>
            <div class="px-4 py-1.5 bg-primary/10 text-primary text-xs font-black rounded-full uppercase tracking-widest animate-pulse">
                In Progress
            </div>
        </div>

        <div class="space-y-6">
            @php
                $steps = [
                    'business_type' => ['label' => 'Business Type', 'icon' => 'business'],
                    'industry' => ['label' => 'Industry', 'icon' => 'factory'],
                    'target_audience' => ['label' => 'Target Audience', 'icon' => 'groups'],
                    'experience_level' => ['label' => 'Experience Level', 'icon' => 'psychology'],
                    'project_name' => ['label' => 'First Project Name', 'icon' => 'rocket_launch'],
                    'project_description' => ['label' => 'Project Description', 'icon' => 'description'],
                    'first_task' => ['label' => 'First Task', 'icon' => 'task_alt'],
                    'call_followup_preference' => ['label' => 'Follow-up Choice', 'icon' => 'phone_callback'],
                ];
            @endphp

            @foreach($steps as $key => $step)
            <div id="step-{{ $key }}" class="flex items-center gap-6 group opacity-40 transition-all duration-500">
                <div class="step-icon w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 group-[.active]:bg-primary/10 group-[.active]:text-primary group-[.completed]:bg-green-500 group-[.completed]:text-white transition-all duration-500">
                    <span class="material-symbols-outlined text-2xl">{{ $step['icon'] }}</span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-slate-400 group-[.active]:text-slate-900 group-[.completed]:text-slate-900 transition-colors">{{ $step['label'] }}</h4>
                        <span class="step-status text-[10px] font-black uppercase tracking-tighter text-slate-300 group-[.active]:text-primary group-[.completed]:text-green-500">Pending</span>
                    </div>
                    <div class="step-value text-sm text-slate-400 mt-0.5 h-5 italic group-[.completed]:not-italic group-[.completed]:text-slate-600 transition-all">Waiting for answer...</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script>
    // Initialize countdown
    let seconds = 5;
    const countdownEl = document.getElementById('countdown');
    
    const interval = setInterval(() => {
        seconds--;
        if (countdownEl) countdownEl.innerText = seconds;
        
        if (seconds <= 0) {
            clearInterval(interval);
        }
    }, 1000);

    // Initialize Echo for live updates
    document.addEventListener('DOMContentLoaded', () => {
        const userId = {{ auth()->id() }};
        const statusEl = document.getElementById('connection-status');
        const progressEl = document.getElementById('onboarding-progress');
        
        // We use Pusher directly or window.Echo if available from app.js
        // Since app.js might not be fully initialized or custom, let's use a robust check
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            wsHost: '{{ config('broadcasting.connections.pusher.options.host') }}',
            wsPort: {{ config('broadcasting.connections.pusher.options.port', 80) }},
            wssPort: {{ config('broadcasting.connections.pusher.options.port', 443) }},
            forceTLS: {{ config('broadcasting.connections.pusher.options.useTLS') ? 'true' : 'false' }},
            enabledTransports: ['ws', 'wss'],
            channelAuthorization: {
                endpoint: "/broadcasting/auth",
                headers: { "X-CSRF-Token": "{{ csrf_token() }}" }
            }
        });

        const channel = pusher.subscribe('private-user.' + userId);

        channel.bind('call.progress', (data) => {
            console.log('Call Progress:', data);
            
            if (data.field === 'complete') {
                // Redirect to project dashboard
                window.location.href = '/projects/' + data.value;
                return;
            }

            // Show progress container on first update
            progressEl.classList.remove('hidden');
            statusEl.innerHTML = '<span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span> CALL IN PROGRESS';
            statusEl.classList.replace('bg-slate-900', 'bg-blue-600');

            const stepRow = document.getElementById('step-' + data.field);
            if (stepRow) {
                stepRow.classList.remove('opacity-40');
                stepRow.classList.add('completed');
                
                const statusLabel = stepRow.querySelector('.step-status');
                const valueLabel = stepRow.querySelector('.step-value');
                
                statusLabel.innerText = 'Captured';
                valueLabel.innerText = data.value;

                // Scroll into view if needed
                stepRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });
</script>
@endsection
