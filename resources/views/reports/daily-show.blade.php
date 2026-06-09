@php
    $title = 'Daily Report';
    $pageTitle = 'Daily Report';
    $activeNav = 'reports';
    $tasksData = $report->tasks_data ?? [];
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Daily Summary</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $report->report_date->format('l, F j, Y') }}</p>
        </div>
        <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Back
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-gray-900">{{ $report->total_tasks }}</div>
            <div class="text-[10px] font-medium uppercase tracking-wider text-gray-400 mt-1">Total</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $report->completed_tasks }}</div>
            <div class="text-[10px] font-medium uppercase tracking-wider text-gray-400 mt-1">Completed</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ $report->pending_tasks }}</div>
            <div class="text-[10px] font-medium uppercase tracking-wider text-gray-400 mt-1">Pending</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-gray-400">{{ $report->discarded_tasks }}</div>
            <div class="text-[10px] font-medium uppercase tracking-wider text-gray-400 mt-1">Discarded</div>
        </div>
    </div>

    {{-- AI Summary --}}
    @if($report->summary)
    <div class="bg-primary/5 rounded-xl border border-primary/10 p-6">
        <div class="flex items-center gap-1.5 mb-3">
            <span class="material-symbols-outlined text-[18px] text-primary">auto_awesome</span>
            <span class="text-[10px] font-semibold tracking-wider text-primary uppercase">AI Summary</span>
        </div>
        <p class="text-sm text-gray-700 leading-relaxed">{{ $report->summary }}</p>
    </div>
    @endif

    {{-- Task Breakdown --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Task Breakdown</h3>

        <div class="space-y-2">
            @forelse ($tasksData as $task)
                @php
                    $statusStyles = [
                        'completed' => 'border-green-200 bg-green-50',
                        'pending' => 'border-yellow-200 bg-yellow-50',
                        'discarded' => 'border-gray-200 bg-gray-50',
                    ];
                    $statusIcons = [
                        'completed' => 'check_circle',
                        'pending' => 'pending',
                        'discarded' => 'do_not_disturb',
                    ];
                    $statusColors = [
                        'completed' => 'text-green-600',
                        'pending' => 'text-yellow-600',
                        'discarded' => 'text-gray-400',
                    ];
                    $style = $statusStyles[$task['status']] ?? 'border-gray-100 bg-white';
                    $icon = $statusIcons[$task['status']] ?? 'task';
                    $color = $statusColors[$task['status']] ?? 'text-gray-500';
                @endphp
                <div class="flex items-start gap-3 p-3 rounded-lg border {{ $style }}">
                    <span class="material-symbols-outlined {{ $color }} text-[20px]">{{ $icon }}</span>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-medium text-gray-900 {{ $task['status'] === 'completed' ? 'line-through text-gray-400' : '' }}">{{ $task['title'] }}</h4>
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-medium
                                {{ match($task['priority'] ?? 'medium') { 'high' => 'bg-red-50 text-red-700', 'low' => 'bg-green-50 text-green-700', default => 'bg-yellow-50 text-yellow-700' } }}">
                                {{ $task['priority'] ?? 'medium' }}
                            </span>
                        </div>
                        @if($task['details'] ?? null)
                            <p class="text-xs text-gray-500 mt-0.5">{{ $task['details'] }}</p>
                        @endif
                        @if($task['estimated_minutes'] ?? null)
                            <span class="inline-flex items-center gap-0.5 text-[11px] text-gray-400 mt-1">
                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                {{ $task['estimated_minutes'] }} min
                            </span>
                        @endif
                    </div>
                    <span class="text-[10px] font-medium {{ $color }}">
                        {{ $task['status'] }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-6">No task data available.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
