@extends('admin.layouts.app', ['title' => 'Call Details', 'activeNav' => 'calls', 'pageTitle' => 'Call Details'])

@section('content')
<div class="max-w-7xl">
    <a href="{{ route('admin.calls.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-primary transition-colors mb-6">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Back to Call Logs
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div>
            <div class="rounded-2xl border border-gray-200 bg-white p-6 space-y-5">
                <div class="flex items-center gap-4">
                    <div class="h-14 w-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[32px]">call</span>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-400 uppercase tracking-wider">Call ID</div>
                        <div class="text-sm font-mono text-gray-900 break-all">{{ $call->call_id ?? '—' }}</div>
                    </div>
                </div>

                <div class="h-px bg-gray-100"></div>

                <div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">User</div>
                    @if($call->user)
                        <a href="{{ route('admin.users.show', $call->user) }}" class="flex items-center gap-3 group">
                            <div class="h-10 w-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                {{ substr($call->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $call->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $call->user->email }}</div>
                            </div>
                        </a>
                    @else
                        <span class="text-sm text-gray-500">Deleted User</span>
                    @endif
                </div>

                <div class="h-px bg-gray-100"></div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status</div>
                        <span class="inline-flex items-center gap-1.5 mt-1 px-2.5 py-1 rounded-lg text-xs font-bold
                            {{ $call->status === 'completed' ? 'bg-green-50 text-green-700' : '' }}
                            {{ $call->status === 'missed' ? 'bg-red-50 text-red-700' : '' }}
                            {{ $call->status === 'busy' ? 'bg-amber-50 text-amber-700' : '' }}
                            {{ $call->status === 'failed' ? 'bg-gray-50 text-gray-600' : '' }}
                            {{ !in_array($call->status, ['completed', 'missed', 'busy', 'failed']) ? 'bg-blue-50 text-blue-700' : '' }}">
                            {{ $call->status ?? 'unknown' }}
                        </span>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Direction</div>
                        <div class="mt-1 flex items-center gap-1.5 text-sm font-semibold text-gray-900">
                            <span class="material-symbols-outlined text-[18px]">{{ $call->direction === 'inbound' ? 'call_received' : 'call_made' }}</span>
                            {{ $call->direction ?? '—' }}
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Duration</div>
                        <div class="mt-1 text-sm font-semibold text-gray-900">
                            @if($call->duration)
                                {{ gmdate('i:s', $call->duration) }}
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Date</div>
                        <div class="mt-1 text-sm font-semibold text-gray-900">{{ $call->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $call->created_at->format('h:i A') }}</div>
                    </div>
                </div>

                @if($call->recording_url)
                    <div class="h-px bg-gray-100"></div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Recording</div>
                        <audio controls class="w-full" src="{{ $call->recording_url }}">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 h-full flex flex-col">
                <h3 class="text-lg font-extrabold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[22px]">description</span>
                    Transcript
                </h3>

                @if($call->transcript)
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 flex-1 overflow-y-auto max-h-[600px]">
                        <pre class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap font-sans">{{ $call->transcript }}</pre>
                    </div>
                @else
                    <div class="text-center py-12 flex-1 flex flex-col items-center justify-center">
                        <span class="material-symbols-outlined text-4xl text-gray-300 mb-3">description</span>
                        <p class="text-sm text-gray-500 font-medium">No transcript available</p>
                        <p class="text-xs text-gray-400 mt-1">This call does not have a transcript.</p>
                    </div>
                @endif
            </div>
        </div>

        @if($call->metadata)
            <div class="lg:col-span-1">
                <div class="rounded-2xl border border-gray-200 bg-white p-6">
                    <h3 class="text-lg font-extrabold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[22px]">data_object</span>
                        Metadata
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 overflow-x-auto">
                        <pre class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap font-mono">{{ json_encode($call->metadata, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
