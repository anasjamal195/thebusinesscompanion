@extends('admin.layouts.app', ['title' => 'Call Logs', 'activeNav' => 'calls', 'pageTitle' => 'Call Logs'])

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">User</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Direction</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Duration</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="text-right px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($calls as $call)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.users.show', $call->user) }}" class="flex items-center gap-3 group">
                                <div class="h-10 w-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                    {{ substr($call->user?->name ?? '?', 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-gray-900 group-hover:text-primary transition-colors truncate">{{ $call->user?->name ?? 'Deleted User' }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ $call->user?->email ?? '—' }}</div>
                                </div>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold
                                {{ $call->status === 'completed' ? 'bg-green-50 text-green-700' : '' }}
                                {{ $call->status === 'missed' ? 'bg-red-50 text-red-700' : '' }}
                                {{ $call->status === 'busy' ? 'bg-amber-50 text-amber-700' : '' }}
                                {{ $call->status === 'failed' ? 'bg-gray-50 text-gray-600' : '' }}
                                {{ !in_array($call->status, ['completed', 'missed', 'busy', 'failed']) ? 'bg-blue-50 text-blue-700' : '' }}">
                                @if($call->status === 'completed')
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                @elseif($call->status === 'missed')
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                @endif
                                {{ $call->status ?? 'unknown' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5 text-sm text-gray-600">
                                <span class="material-symbols-outlined text-[18px]">{{ $call->direction === 'inbound' ? 'call_received' : 'call_made' }}</span>
                                {{ $call->direction ?? '—' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                            @if($call->duration)
                                {{ gmdate('i:s', $call->duration) }}
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $call->created_at->format('M d, Y h:i A') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.calls.show', $call) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-primary hover:text-primary-container transition-colors">
                                View Details
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">No calls found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($calls->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $calls->links() }}
        </div>
    @endif
</div>
@endsection
