@php
    $title = 'Call Logs';
    $pageTitle = 'Call History';
    $activeNav = 'calls';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div>
        <h1 class="text-lg font-bold text-gray-900">Call History</h1>
        <p class="text-sm text-gray-500 mt-0.5">Review your conversations and insights from your AI companion.</p>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined">call</span>
            </div>
            <div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Calls</div>
                <div class="text-xl font-bold text-gray-900">{{ $calls->total() }}</div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                <span class="material-symbols-outlined">timer</span>
            </div>
            <div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Duration</div>
                <div class="text-xl font-bold text-gray-900">{{ number_format($calls->sum('duration') / 60, 1) }}m</div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                <span class="material-symbols-outlined">description</span>
            </div>
            <div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Recorded Sessions</div>
                <div class="text-xl font-bold text-gray-900">{{ $calls->whereNotNull('recording_url')->count() }}</div>
            </div>
        </div>
    </div>

    {{-- Call List --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-5 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Companion</th>
                        <th class="px-5 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Date & Time</th>
                        <th class="px-5 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Duration</th>
                        <th class="px-5 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-5 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($calls as $call)
                    <tr class="group hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                                    <span class="material-symbols-outlined text-[22px]">smart_toy</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">dialer.best Agent</div>
                                    <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">AI Assistant</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $call->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $call->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-1.5 text-sm font-medium text-gray-900">
                                <span class="material-symbols-outlined text-gray-400 text-[16px]">schedule</span>
                                {{ gmdate("i:s", $call->duration ?? 0) }}
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @if($call->status === 'completed')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-50 text-green-700 rounded-md text-[10px] font-semibold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Completed
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gray-100 text-gray-500 rounded-md text-[10px] font-semibold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                    {{ ucfirst($call->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($call->recording_url)
                                    <a href="{{ $call->recording_url }}" target="_blank"
                                       class="w-9 h-9 rounded-lg bg-white border border-gray-200 shadow-sm flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary/30 transition-all"
                                       title="Download Audio">
                                        <span class="material-symbols-outlined text-[18px]">download</span>
                                    </a>
                                @endif
                                <button onclick="showDetails({{ $call->id }})"
                                        class="px-4 py-2 rounded-lg bg-gray-900 text-white text-[10px] font-semibold uppercase tracking-wider hover:bg-gray-800 transition-all shadow-sm">
                                    View Details
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-gray-300 text-3xl">call_missed</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">No calls found</div>
                                    <p class="text-xs text-gray-500 mt-0.5">Talk to your companion to see your conversation logs here.</p>
                                </div>
                                <a href="{{ route('onboarding.schedule') }}" class="mt-2 px-4 py-2 rounded-lg bg-primary text-white text-xs font-semibold uppercase tracking-wider hover:bg-primary-container transition-all shadow-sm">
                                    Set Up Companion
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($calls->hasPages())
            <div class="px-5 py-4 border-t border-gray-50">
                {{ $calls->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Detail Modal --}}
<div id="call-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/20 backdrop-blur-sm" onclick="hideDetails()"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-xl bg-white shadow-xl flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Call Details</h2>
                <p class="text-xs text-gray-500 mt-0.5" id="modal-subtitle">Loading...</p>
            </div>
            <button onclick="hideDetails()" class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <div class="flex-grow overflow-y-auto p-6 space-y-6 scrollbar-thin">
            <div id="modal-audio-container" class="hidden space-y-2">
                <div class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">Recording</div>
                <audio id="modal-audio" controls class="w-full h-10 rounded-lg"></audio>
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">Full Transcript</div>
                    <button onclick="copyTranscript()" class="text-[10px] font-medium text-primary hover:underline uppercase tracking-wider flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">content_copy</span>
                        Copy Text
                    </button>
                </div>
                <div id="modal-transcript" class="text-sm text-gray-600 leading-relaxed bg-gray-50 p-5 rounded-xl border border-gray-100 min-h-[200px] whitespace-pre-wrap">
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

        document.getElementById('modal-subtitle').innerText = `dialer.best Agent • ${new Date(call.created_at).toLocaleString()}`;
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
        navigator.clipboard.writeText(text).then(() => {
            const btn = event.target.closest('button');
            const original = btn.innerHTML;
            btn.innerHTML = '<span class="material-symbols-outlined text-[14px]">check</span> Copied!';
            setTimeout(() => btn.innerHTML = original, 2000);
        });
    }
</script>

<style>
    .scrollbar-thin::-webkit-scrollbar { width: 5px; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background: #f1f5f9; border-radius: 99px; }
</style>
@endsection
