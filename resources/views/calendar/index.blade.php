@php
    $title = 'Calendar';
    $pageTitle = 'Calendar';
    $activeNav = 'calendar';

    $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $today = now()->setTimezone(auth()->user()->timezone)->toDateString();
    $prevWeek = $weekStart->copy()->subWeek()->toDateString();
    $nextWeek = $weekStart->copy()->addWeek()->toDateString();
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Week Navigation --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <h2 class="text-lg font-bold text-gray-900">Weekly View</h2>
            <span class="text-sm text-gray-500">{{ $weekStart->format('M j') }} — {{ $weekEnd->format('M j, Y') }}</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('calendar.index', ['week_start' => $prevWeek]) }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all">
                <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                Prev
            </a>
            <a href="{{ route('calendar.index') }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all">
                Today
            </a>
            <a href="{{ route('calendar.index', ['week_start' => $nextWeek]) }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all">
                Next
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            </a>
        </div>
    </div>

    {{-- Week Grid --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="grid grid-cols-7 border-b border-gray-100">
            @foreach ($daysOfWeek as $day)
                <div class="px-3 py-2.5 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider border-r border-gray-100 last:border-r-0">
                    {{ $day }}
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-7 divide-x divide-gray-100">
            @for ($i = 0; $i < 7; $i++)
                @php
                    $date = $weekStart->copy()->addDays($i);
                    $dateStr = $date->toDateString();
                    $dayTasks = $tasks->get($dateStr, collect());
                    $isToday = $dateStr === $today;
                    $isPast = $date->isPast() && !$isToday;
                    $completedCount = $dayTasks->where('status', 'completed')->count();
                    $totalCount = $dayTasks->count();
                @endphp
                <div class="min-h-[200px] {{ $isToday ? 'bg-primary/5' : ($isPast ? 'bg-gray-50/50' : 'bg-white') }}">
                    {{-- Date Header --}}
                    <div class="px-2.5 py-2 text-center border-b border-gray-50">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-sm font-medium {{ $isToday ? 'bg-primary text-white' : 'text-gray-700' }}">
                            {{ $date->format('j') }}
                        </span>
                        @if($totalCount > 0)
                            <div class="mt-0.5 flex items-center justify-center gap-0.5">
                                <span class="text-[10px] font-medium text-green-600">{{ $completedCount }}</span>
                                <span class="text-[10px] text-gray-300">/</span>
                                <span class="text-[10px] font-medium text-gray-500">{{ $totalCount }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Tasks --}}
                    <div class="p-1.5 space-y-1">
                        @forelse ($dayTasks as $task)
                            @php
                                $priorityColor = match ($task->priority) {
                                    'high' => 'border-l-red-400 bg-red-50',
                                    'medium' => 'border-l-yellow-400 bg-yellow-50',
                                    'low' => 'border-l-green-400 bg-green-50',
                                    default => 'border-l-gray-300 bg-gray-50',
                                };
                                $isDone = $task->status === 'completed';
                            @endphp
                            <div class="px-2 py-1.5 rounded-md border-l-2 text-xs {{ $priorityColor }} {{ $isDone ? 'opacity-60' : '' }}">
                                <div class="flex items-center gap-1.5">
                                    @if($isDone)
                                        <span class="material-symbols-outlined text-[12px] text-green-600">check_circle</span>
                                    @elseif($task->status === 'discarded')
                                        <span class="material-symbols-outlined text-[12px] text-gray-400">cancel</span>
                                    @else
                                        <span class="material-symbols-outlined text-[12px] text-gray-400">radio_button_unchecked</span>
                                    @endif
                                    <span class="font-medium text-gray-800 {{ $isDone ? 'line-through text-gray-400' : '' }} truncate">
                                        {{ $task->title }}
                                    </span>
                                </div>
                                @if($task->estimated_minutes)
                                    <div class="text-[10px] text-gray-400 mt-0.5 ml-[22px]">{{ $task->estimated_minutes }} min</div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <span class="text-[10px] text-gray-300">No tasks</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endfor
        </div>
    </div>

    {{-- Legend --}}
    <div class="flex items-center gap-4 text-xs text-gray-500">
        <span class="flex items-center gap-1.5">
            <span class="w-3 h-0.5 rounded bg-red-400"></span> High
        </span>
        <span class="flex items-center gap-1.5">
            <span class="w-3 h-0.5 rounded bg-yellow-400"></span> Medium
        </span>
        <span class="flex items-center gap-1.5">
            <span class="w-3 h-0.5 rounded bg-green-400"></span> Low
        </span>
        <span class="flex items-center gap-1.5 ml-4">
            <span class="material-symbols-outlined text-[14px] text-green-600">check_circle</span> Completed
        </span>
        <span class="flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[14px] text-gray-400">radio_button_unchecked</span> Pending
        </span>
    </div>
</div>
@endsection
