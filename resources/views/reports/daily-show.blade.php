@php
    $title = 'Daily Report';
    $pageTitle = 'Daily Report';
    $activeNav = 'reports';
    $tasksData = $report->tasks_data ?? [];
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="{ showShareModal: false, visibility: 'public' }">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Daily Summary</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $report->report_date->format('l, F j, Y') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="showShareModal = true" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">share</span>
                Share Progress
            </button>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Back
            </a>
        </div>
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

    {{-- Share Modal --}}
    <div x-show="showShareModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/20 backdrop-blur-sm" @click.away="showShareModal = false">
        <div class="bg-white rounded-xl shadow-xl max-w-lg w-full relative border border-gray-200" @click.stop>
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Share Your Progress</h3>
                <button @click="showShareModal = false" class="text-gray-400 hover:text-gray-600 p-1 rounded hover:bg-gray-100 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <form action="{{ route('reports.share', $report) }}" method="POST" class="p-5 space-y-4"
                  @submit.prevent="
                      let hidden = [];
                      document.querySelectorAll('.task-checkbox:not(:checked)').forEach(cb => hidden.push(cb.value));
                      document.getElementById('hiddenTaskIds').value = JSON.stringify(hidden);
                      $el.submit();
                  ">
                @csrf
                <input type="hidden" name="hidden_task_ids" id="hiddenTaskIds" value="[]">

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Visibility</label>
                    <div class="flex gap-2">
                        <label class="flex-1 flex items-center gap-2.5 p-3 rounded-lg border cursor-pointer transition-colors"
                               :class="visibility === 'public' ? 'border-primary bg-primary/5' : 'border-gray-200 bg-gray-50 hover:bg-gray-100'">
                            <input type="radio" name="visibility" value="public" x-model="visibility" class="sr-only">
                            <span class="material-symbols-outlined text-[20px]" :class="visibility === 'public' ? 'text-primary' : 'text-gray-400'">public</span>
                            <div>
                                <p class="text-sm font-medium" :class="visibility === 'public' ? 'text-gray-900' : 'text-gray-600'">Public</p>
                                <p class="text-[10px] text-gray-400">Visible to everyone</p>
                            </div>
                        </label>
                        <label class="flex-1 flex items-center gap-2.5 p-3 rounded-lg border cursor-pointer transition-colors"
                               :class="visibility === 'followers' ? 'border-primary bg-primary/5' : 'border-gray-200 bg-gray-50 hover:bg-gray-100'">
                            <input type="radio" name="visibility" value="followers" x-model="visibility" class="sr-only">
                            <span class="material-symbols-outlined text-[20px]" :class="visibility === 'followers' ? 'text-primary' : 'text-gray-400'">people</span>
                            <div>
                                <p class="text-sm font-medium" :class="visibility === 'followers' ? 'text-gray-900' : 'text-gray-600'">Followers Only</p>
                                <p class="text-[10px] text-gray-400">Only your followers</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Tasks (checked = shown in post, unchecked = hidden)</label>
                    <div class="space-y-1.5 max-h-48 overflow-y-auto">
                        @foreach ($tasksData as $task)
                            @php $taskId = $task['id'] ?? 'task_' . $loop->index; @endphp
                            <label class="flex items-center gap-2.5 p-2 rounded-lg border border-gray-100 cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="checkbox" value="{{ $taskId }}" checked
                                       class="task-checkbox rounded border-gray-300 text-primary focus:ring-primary/20">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $task['title'] ?? 'Task' }}</p>
                                    <p class="text-[11px] text-gray-400">
                                        <span class="capitalize">{{ $task['status'] ?? 'pending' }}</span>
                                        @if($task['priority'] ?? null)
                                            &middot; {{ $task['priority'] }}
                                        @endif
                                    </p>
                                </div>
                                <span class="text-xs font-medium text-gray-400">Show</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-500">Your progress will be shared as a post on the Feed with an AI-generated personal message. Unchecked tasks will be hidden.</p>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="button" @click="showShareModal = false" class="flex-1 px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm flex items-center justify-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">dynamic_feed</span>
                        Share to Feed
                    </button>
                </div>
            </form>
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
