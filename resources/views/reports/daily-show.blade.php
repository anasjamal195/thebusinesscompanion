@php
    $title = 'Daily Report';
    $pageTitle = 'Daily Report';
    $activeNav = 'reports';
    $tasksData = $report->tasks_data ?? [];
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Daily Summary</h2>
            <p class="text-sm text-gray-500 font-medium mt-1">{{ $report->report_date->format('l, F j, Y') }}</p>
        </div>
        <a href="{{ route('reports.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl text-sm hover:bg-gray-200 transition-all">
            Back to Reports
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
            <div class="text-3xl font-black text-gray-900">{{ $report->total_tasks }}</div>
            <div class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-1">Total</div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
            <div class="text-3xl font-black text-green-600">{{ $report->completed_tasks }}</div>
            <div class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-1">Completed</div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
            <div class="text-3xl font-black text-yellow-600">{{ $report->pending_tasks }}</div>
            <div class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-1">Pending</div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
            <div class="text-3xl font-black text-gray-400">{{ $report->discarded_tasks }}</div>
            <div class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-1">Discarded</div>
        </div>
    </div>

    {{-- AI Summary --}}
    @if($report->summary)
    <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-[2rem] p-8 border border-primary/10">
        <div class="flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined text-primary">auto_awesome</span>
            <span class="text-[10px] font-black uppercase tracking-widest text-primary">AI Summary</span>
        </div>
        <p class="text-gray-700 text-base leading-relaxed">{{ $report->summary }}</p>
    </div>
    @endif

    {{-- Task Breakdown --}}
    <div class="bg-white rounded-[2.5rem] p-8 shadow-lg shadow-gray-200/30 border border-gray-50">
        <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6">Task Breakdown</h3>

        <div class="space-y-3">
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
                <div class="flex items-start gap-4 p-4 rounded-2xl border {{ $style }}">
                    <span class="material-symbols-outlined {{ $color }}">{{ $icon }}</span>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <h4 class="font-bold text-gray-900 {{ $task['status'] === 'completed' ? 'line-through text-gray-400' : '' }}">{{ $task['title'] }}</h4>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                {{ match($task['priority'] ?? 'medium') { 'high' => 'bg-red-100 text-red-700', 'low' => 'bg-green-100 text-green-700', default => 'bg-yellow-100 text-yellow-700' } }}">
                                {{ $task['priority'] ?? 'medium' }}
                            </span>
                        </div>
                        @if($task['details'] ?? null)
                            <p class="text-sm text-gray-500 mt-1">{{ $task['details'] }}</p>
                        @endif
                        @if($task['estimated_minutes'] ?? null)
                            <div class="flex items-center gap-1 text-xs font-bold text-gray-400 mt-1">
                                <span class="material-symbols-outlined text-[14px]">timer</span>
                                {{ $task['estimated_minutes'] }} min
                            </div>
                        @endif
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest {{ $color }}">
                        {{ $task['status'] }}
                    </span>
                </div>
            @empty
                <p class="text-gray-400 text-center py-8">No task data available.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
