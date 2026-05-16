@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-in fade-in duration-700">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Call History</h1>
            <p class="text-slate-500 font-medium mt-1">Review your conversations and insights from your AI companions.</p>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined">call</span>
            </div>
            <div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Calls</div>
                <div class="text-2xl font-black text-slate-900">{{ $calls->total() }}</div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-2xl bg-green-500/10 text-green-600 flex items-center justify-center">
                <span class="material-symbols-outlined">timer</span>
            </div>
            <div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Duration</div>
                <div class="text-2xl font-black text-slate-900">{{ number_format($calls->sum('duration') / 60, 1) }}m</div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center">
                <span class="material-symbols-outlined">description</span>
            </div>
            <div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Recorded Sessions</div>
                <div class="text-2xl font-black text-slate-900">{{ $calls->whereNotNull('recording_url')->count() }}</div>
            </div>
        </div>
    </div>

    {{-- Call List --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[11px] font-black uppercase tracking-widest text-slate-400">Companion</th>
                        <th class="px-8 py-5 text-[11px] font-black uppercase tracking-widest text-slate-400">Date & Time</th>
                        <th class="px-8 py-5 text-[11px] font-black uppercase tracking-widest text-slate-400">Duration</th>
                        <th class="px-8 py-5 text-[11px] font-black uppercase tracking-widest text-slate-400">Status</th>
                        <th class="px-8 py-5 text-[11px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($calls as $call)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img src="{{ $call->aiCharacter->avatar_url }}" alt="{{ $call->aiCharacter->name }}" 
                                         class="w-12 h-12 rounded-2xl object-cover ring-2 ring-white shadow-sm group-hover:scale-105 transition-transform">
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-slate-900">{{ $call->aiCharacter->name }}</div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $call->aiCharacter->occupation }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-sm font-bold text-slate-900">{{ $call->created_at->format('M d, Y') }}</div>
                            <div class="text-xs font-medium text-slate-500">{{ $call->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2 text-sm font-bold text-slate-900">
                                <span class="material-symbols-outlined text-slate-400 text-[18px]">schedule</span>
                                {{ gmdate("i:s", $call->duration ?? 0) }}
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @if($call->status === 'completed')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-500/10 text-green-600 rounded-full text-[10px] font-black uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Completed
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
                                    {{ ucfirst($call->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($call->recording_url)
                                    <a href="{{ $call->recording_url }}" target="_blank" 
                                       class="w-10 h-10 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center justify-center text-slate-500 hover:text-primary hover:border-primary/30 transition-all active:scale-90"
                                       title="Download Audio">
                                        <span class="material-symbols-outlined text-[20px]">download</span>
                                    </a>
                                @endif
                                <button onclick="showDetails({{ $call->id }})" 
                                        class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest hover:bg-slate-800 transition-all active:scale-95 shadow-lg shadow-slate-900/10">
                                    View Details
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-slate-300 text-3xl">call_missed</span>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-slate-900">No calls found</div>
                                    <p class="text-xs text-slate-500 mt-1">Talk to your companion to see your conversation logs here.</p>
                                </div>
                                <a href="{{ route('companions.index') }}" class="mt-4 px-6 py-2.5 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/20">
                                    Find a Companion
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($calls->hasPages())
            <div class="px-8 py-6 border-t border-slate-50">
                {{ $calls->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Detail Modal --}}
<div id="call-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" onclick="hideDetails()"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-2xl bg-white shadow-2xl flex flex-col animate-in slide-in-from-right duration-500">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-xl font-black text-slate-900">Call Details</h2>
                <p class="text-xs text-slate-500 font-medium mt-1" id="modal-subtitle">Loading...</p>
            </div>
            <button onclick="hideDetails()" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="flex-grow overflow-y-auto p-8 space-y-8 scrollbar-thin">
            {{-- Audio Player --}}
            <div id="modal-audio-container" class="hidden space-y-3">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Recording</div>
                <audio id="modal-audio" controls class="w-full h-12 rounded-xl"></audio>
            </div>

            {{-- Transcript --}}
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Full Transcript</div>
                    <button onclick="copyTranscript()" class="text-[10px] font-bold text-primary hover:underline uppercase tracking-widest flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">content_copy</span>
                        Copy Text
                    </button>
                </div>
                <div id="modal-transcript" class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-6 rounded-3xl border border-slate-100 min-h-[200px] whitespace-pre-wrap">
                    Loading transcript...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const calls = {!! json_encode($calls->items()) !!};
    
    function showDetails(id) {
        const call = calls.find(c => c.id === id);
        if (!call) return;

        document.getElementById('modal-subtitle').innerText = `${call.ai_character.name} • ${new Date(call.created_at).toLocaleString()}`;
        document.getElementById('modal-transcript').innerText = call.transcript || 'No transcript available for this call.';
        
        const audioContainer = document.getElementById('modal-audio-container');
        const audio = document.getElementById('modal-audio');
        
        if (call.recording_url) {
            audio.src = call.recording_url;
            audioContainer.classList.remove('hidden');
        } else {
            audioContainer.classList.add('hidden');
        }

        document.getElementById('call-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function hideDetails() {
        document.getElementById('call-modal').classList.add('hidden');
        document.body.style.overflow = '';
        document.getElementById('modal-audio').pause();
    }

    function copyTranscript() {
        const text = document.getElementById('modal-transcript').innerText;
        navigator.clipboard.writeText(text);
        alert('Transcript copied to clipboard!');
    }
</script>

<style>
    .scrollbar-thin::-webkit-scrollbar { width: 5px; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background: #f1f5f9; border-radius: 99px; }
</style>
@endsection
