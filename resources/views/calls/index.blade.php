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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
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
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                <span class="material-symbols-outlined">payments</span>
            </div>
            <div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Cost</div>
                <div class="text-xl font-bold text-gray-900">${{ number_format($totalCost, 2) }}</div>
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
                        <th class="px-5 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Cost</th>
                        <th class="px-5 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-5 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($calls as $call)
                    <tr class="group hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
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
                            <div class="text-sm font-semibold text-gray-900">
                                ${{ number_format($call->cost ?? 0, 2) }}
                            </div>
                            <div class="text-[10px] text-gray-400">
                                @ {{ '$' . number_format($perMinuteRate, 2) }}/min
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
                            <div class="flex items-center justify-end gap-1.5">
                                @if($call->recording_url)
                                    <a href="{{ $call->recording_url }}" target="_blank"
                                       class="w-8 h-8 rounded-lg bg-white border border-gray-200 shadow-sm flex items-center justify-center text-gray-500 hover:text-teal-600 hover:border-teal-300 transition-all"
                                       title="Download Audio">
                                        <span class="material-symbols-outlined text-[16px]">download</span>
                                    </a>
                                @endif
                                @if($call->transcript)
                                    <a href="{{ route('calls.transcript', $call) }}"
                                       class="w-8 h-8 rounded-lg bg-white border border-gray-200 shadow-sm flex items-center justify-center text-gray-500 hover:text-teal-600 hover:border-teal-300 transition-all"
                                       title="Download PDF Transcript">
                                        <span class="material-symbols-outlined text-[16px]">picture_as_pdf</span>
                                    </a>
                                @endif
                                <button onclick="showDetails({{ $call->id }})"
                                        class="px-3 py-2 rounded-lg bg-gray-900 text-white text-[10px] font-semibold uppercase tracking-wider hover:bg-gray-800 transition-all shadow-sm">
                                    View
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
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
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Call Details</h2>
                <p class="text-xs text-gray-500 mt-0.5" id="modal-subtitle">Loading...</p>
            </div>
            <div class="flex items-center gap-2">
                <a id="modal-pdf-link" href="#" target="_blank"
                   class="hidden text-[10px] font-semibold uppercase tracking-wider text-teal-600 hover:underline flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">picture_as_pdf</span>
                    Generate PDF Transcript
                </a>
                <button onclick="hideDetails()" class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        </div>

        {{-- Body --}}
        <div class="flex-grow overflow-y-auto p-6 space-y-6 scrollbar-thin">
            {{-- Audio Player --}}
            <div id="modal-audio-container" class="hidden">
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-semibold uppercase tracking-wider text-teal-600 shrink-0">Listen to Recording</span>
                    </div>
                    <div class="mt-2">
                        <audio id="modal-audio" controls
                               class="w-full h-10 rounded-lg"></audio>
                    </div>
                </div>
            </div>

            {{-- Transcript --}}
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">Transcript</div>
                    <button onclick="copyTranscript()" class="text-[10px] font-medium text-teal-600 hover:underline uppercase tracking-wider flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">content_copy</span>
                        Copy
                    </button>
                </div>
                <div id="modal-transcript" class="space-y-2">
                    <div class="flex justify-center">
                        <span class="text-xs text-gray-400">Loading transcript...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const calls = {!! json_encode($calls->items()) !!};
    let currentAudio = null;

    function showDetails(id) {
        const call = calls.find(c => c.id === id);
        if (!call) return;

        document.getElementById('modal-subtitle').innerText = `dialer.best Agent • ${new Date(call.created_at).toLocaleString()}`;

        // PDF link in modal header
        const pdfLink = document.getElementById('modal-pdf-link');
        if (call.transcript) {
            pdfLink.href = `{{ url('calls') }}/${call.id}/transcript`;
            pdfLink.classList.remove('hidden');
        } else {
            pdfLink.classList.add('hidden');
        }

        // Audio player
        const audioContainer = document.getElementById('modal-audio-container');
        const audio = document.getElementById('modal-audio');

        if (call.recording_url) {
            audio.src = call.recording_url;
            audioContainer.classList.remove('hidden');
        } else {
            audioContainer.classList.add('hidden');
        }

        // Transcript
        renderTranscript(call.transcript);

        document.getElementById('call-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function hideDetails() {
        document.getElementById('call-modal').classList.add('hidden');
        document.body.style.overflow = '';
        const audio = document.getElementById('modal-audio');
        audio.pause();
    }

    // ── Chat Transcript ──────────────────────────────────────────────────────

    function renderTranscript(text) {
        const container = document.getElementById('modal-transcript');
        container.innerHTML = '';

        if (!text) {
            container.innerHTML = `<div class="flex justify-center"><span class="text-xs text-gray-400">No transcript available for this call.</span></div>`;
            return;
        }

        const messages = parseTranscript(text);
        let hasMarkers = false;

        messages.forEach((msg, i) => {
            if (msg.type === 'user') hasMarkers = true;
            const div = document.createElement('div');
            div.className = 'flex ' + (msg.type === 'user' ? 'justify-end' : 'justify-start');

            const bubble = document.createElement('div');
            bubble.className = 'max-w-[80%] px-3.5 py-2.5 text-sm leading-relaxed rounded-2xl ' +
                (msg.type === 'user'
                    ? 'bg-teal-600 text-white rounded-br-md'
                    : msg.type === 'system'
                        ? 'bg-gray-100 text-gray-500 italic text-xs text-center max-w-full rounded-lg'
                        : 'bg-gray-100 text-gray-800 rounded-bl-md'
                );

            bubble.textContent = msg.text;
            div.appendChild(bubble);
            container.appendChild(div);
        });

        // If no markers found, show as single AI message
        if (!hasMarkers && messages.length === 1 && messages[0].type === 'ai') {
            container.innerHTML = '';
            const div = document.createElement('div');
            div.className = 'flex justify-start';
            const bubble = document.createElement('div');
            bubble.className = 'max-w-[85%] px-4 py-3 text-sm leading-relaxed bg-gray-100 text-gray-800 rounded-2xl rounded-bl-md whitespace-pre-wrap';
            bubble.textContent = text;
            div.appendChild(bubble);
            container.appendChild(div);
        }
    }

    function parseTranscript(text) {
        const lines = text.split('\n');
        const messages = [];

        for (const line of lines) {
            const trimmed = line.trim();
            if (!trimmed) continue;

            const userMatch = trimmed.match(/^User:\s*(.*)/i);
            const aiMatch   = trimmed.match(/^(?:AI|Agent):\s*(.*)/i);

            if (userMatch) {
                messages.push({ type: 'user', text: userMatch[1] });
            } else if (aiMatch) {
                messages.push({ type: 'ai', text: aiMatch[1] });
            } else if (messages.length > 0) {
                const last = messages[messages.length - 1];
                if (last.type !== 'system') {
                    last.text += '\n' + trimmed;
                } else {
                    messages.push({ type: 'ai', text: trimmed });
                }
            } else {
                messages.push({ type: 'ai', text: trimmed });
            }
        }

        return messages.length > 0 ? messages : [{ type: 'ai', text: text }];
    }

    // ── Copy Transcript ──────────────────────────────────────────────────────

    function copyTranscript() {
        const container = document.getElementById('modal-transcript');
        const text = Array.from(container.querySelectorAll('.text-sm'))
            .map(el => el.textContent)
            .join('\n');
        navigator.clipboard.writeText(text || 'No transcript available.').then(() => {
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

    /* ── Audio Player ──────────────────────────────────────────────────────── */
    #modal-audio::-webkit-media-controls-panel {
        background: #f9fafb;
    }

    /* ── Chat Bubbles ──────────────────────────────────────────────────────── */
    #modal-transcript {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
</style>
@endsection
