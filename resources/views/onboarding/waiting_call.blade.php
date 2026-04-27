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
        <div class="flex items-center gap-4 px-6 py-3 bg-slate-900 text-white rounded-full text-sm font-bold tracking-wide">
            <span class="w-2 h-2 bg-green-400 rounded-full animate-ping"></span>
            WAITING FOR CONNECTION...
        </div>
        
        <p class="text-slate-400 text-sm italic">
            "I'll get to you once this is done"
        </p>
    </div>
</div>

<script>
    let seconds = 5;
    const countdownEl = document.getElementById('countdown');
    
    const interval = setInterval(() => {
        seconds--;
        countdownEl.innerText = seconds;
        
        if (seconds <= 0) {
            clearInterval(interval);
            // Optionally redirect or show a "Connected" state
        }
    }, 1000);
</script>
@endsection
