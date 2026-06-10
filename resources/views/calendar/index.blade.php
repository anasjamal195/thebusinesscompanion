@php
    $title = 'Calendar';
    $pageTitle = 'Calendar';
    $activeNav = 'calendar';

    $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $tz = auth()->user()->timezone;
    $today = now()->setTimezone($tz)->toDateString();

    $startDayOfWeek = (int) $monthStart->format('N') - 1;
    $daysInMonth = $monthStart->daysInMonth;
    $totalCells = ceil(($startDayOfWeek + $daysInMonth) / 7) * 7;
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <h2 class="text-lg font-bold text-gray-900">{{ $monthStart->format('F Y') }}</h2>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('calendar.index', ['month' => $prevMonth, 'year' => $prevYear]) }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all">
                <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                Prev
            </a>
            <a href="{{ route('calendar.index') }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all">
                Today
            </a>
            <a href="{{ route('calendar.index', ['month' => $nextMonth, 'year' => $nextYear]) }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all">
                Next
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="grid grid-cols-7 border-b border-gray-100">
            @foreach ($daysOfWeek as $day)
                <div class="px-3 py-2.5 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider border-r border-gray-100 last:border-r-0">
                    {{ $day }}
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-7 divide-x divide-gray-100">
            @for ($i = 0; $i < $totalCells; $i++)
                @php
                    $dayNum = $i - $startDayOfWeek + 1;
                    $isInMonth = $dayNum >= 1 && $dayNum <= $daysInMonth;
                    $dateStr = $isInMonth ? $monthStart->copy()->setDay($dayNum)->toDateString() : null;
                    $dayTasks = $isInMonth && isset($tasks[$dateStr]) ? $tasks[$dateStr] : collect();
                    $isToday = $dateStr === $today;
                    $isPast = $dateStr && $dateStr < $today;
                    $isCompleted = $dateStr && in_array($dateStr, $completedDates ?? []);
                    $totalCount = $dayTasks->count();
                    $completedCount = $dayTasks->where('status', 'completed')->count();

                    $dateStatusClass = '';
                    if ($totalCount > 0) {
                        if ($completedCount === $totalCount) {
                            $dateStatusClass = 'bg-green-500 text-white';
                        } elseif ($completedCount > 0) {
                            $dateStatusClass = 'bg-amber-500 text-white';
                        } else {
                            $dateStatusClass = 'bg-red-500 text-white';
                        }
                    }

                    $cellBg = $isToday ? 'bg-primary-fixed' : ($isInMonth ? 'bg-white' : 'bg-gray-50/50');
                    $cellExtra = $isPast ? 'opacity-70' : '';
                    $completedExtra = $isCompleted && !$isToday ? 'bg-emerald-50' : '';
                    $todayHighlight = $isToday ? 'ring-2 ring-primary/30 ring-inset' : '';
                @endphp
                <div class="min-h-[120px] {{ $cellBg }} {{ $completedExtra }} {{ $cellExtra }} {{ $todayHighlight }} {{ $i % 7 === 6 ? '' : 'border-b border-gray-100' }}">
                    @if ($isInMonth)
                        <div class="px-2 py-1.5 text-center">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-sm font-medium {{ $isToday ? 'bg-primary text-white ring-2 ring-primary/30' : ($dateStatusClass ?: ($isPast ? 'text-gray-400' : 'text-gray-700')) }}">
                                {{ $dayNum }}
                            </span>
                        </div>

                        <div class="px-1.5 space-y-1 max-h-[100px] overflow-y-auto">
                            @foreach ($dayTasks as $task)
                                @php
                                    $priorityColor = match ($task->priority) {
                                        'high' => 'border-l-red-400 bg-red-50 text-red-700',
                                        'medium' => 'border-l-amber-400 bg-amber-50 text-amber-700',
                                        'low' => 'border-l-green-400 bg-green-50 text-green-700',
                                        default => 'border-l-gray-300 bg-gray-50 text-gray-700',
                                    };
                                    $isDone = $task->status === 'completed';
                                    $hiddenClass = $loop->index >= 2 ? 'hidden task-extra' : '';
                                @endphp
                                <div
                                    class="px-2 py-1 rounded border-l-2 text-xs cursor-pointer hover:brightness-95 transition-all {{ $priorityColor }} {{ $isDone ? 'opacity-60' : '' }} {{ $hiddenClass }}"
                                    onclick="openModal({{ $task->id }}, '{{ addslashes($task->title) }}', '{{ $task->priority }}', '{{ $task->status }}', '{{ $task->estimated_minutes }}')"
                                >
                                    <div class="flex items-center gap-1">
                                        <span class="truncate font-medium {{ $isDone ? 'line-through text-gray-400' : '' }}">{{ $task->title }}</span>
                                    </div>
                                </div>
                            @endforeach
                            @if ($dayTasks->count() > 2)
                                <button onclick="this.classList.add('hidden'); this.parentElement.querySelectorAll('.task-extra').forEach(el => el.classList.remove('hidden'))" class="text-xs text-primary font-medium hover:underline">
                                    +{{ $dayTasks->count() - 2 }} more
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            @endfor
        </div>
    </div>
</div>

<div id="taskModal" class="fixed inset-0 z-50 hidden" aria-modal="true" role="dialog">
    <div class="absolute inset-0 bg-black/40" onclick="closeModal()"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-gray-500 w-24">Priority</span>
                    <span id="modalPriority" class="font-medium text-gray-800"></span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-gray-500 w-24">Status</span>
                    <span id="modalStatus" class="font-medium text-gray-800"></span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-gray-500 w-24">Est. Minutes</span>
                    <span id="modalMinutes" class="font-medium text-gray-800"></span>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button id="modalCompleteBtn" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition-all">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    Mark Complete
                </button>
                <a id="modalEditLink" href="#" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all">
                    <span class="material-symbols-outlined text-[16px]">edit</span>
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(id, title, priority, status, minutes) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalPriority').textContent = priority.charAt(0).toUpperCase() + priority.slice(1);
    document.getElementById('modalStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1);
    document.getElementById('modalMinutes').textContent = minutes ? minutes + ' min' : '\u2014';
    document.getElementById('modalCompleteBtn').setAttribute('data-task-id', id);
    document.getElementById('modalEditLink').href = '/tasks';
    document.getElementById('taskModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('taskModal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('modalCompleteBtn').addEventListener('click', function () {
        var taskId = this.getAttribute('data-task-id');
        if (!taskId) return;
        fetch('/tasks/' + taskId + '/complete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        }).then(function () {
            location.reload();
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });
});
</script>
@endsection
