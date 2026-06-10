@php
    $title = 'Hall of Fame';
    $pageTitle = 'Hall of Fame';
    $activeNav = 'hall-of-fame';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-lg font-bold text-gray-900">Hall of Fame</h2>
        <p class="text-sm text-gray-500 mt-0.5">Top performers and community leaders.</p>
    </div>

    {{-- Longest Streaks --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center gap-2 mb-5">
            <span class="material-symbols-outlined text-[20px] text-orange-500">local_fire_department</span>
            <h3 class="text-sm font-semibold text-gray-900">Longest Streaks</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach ($longestStreaks as $index => $entry)
                <a href="{{ route('profiles.public', $entry) }}" class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-orange-200 hover:bg-orange-50/50 transition-all group relative">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold shrink-0
                        {{ $index === 0 ? 'bg-yellow-400 text-white' : ($index === 1 ? 'bg-gray-300 text-white' : ($index === 2 ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-500')) }}">
                        {{ $index + 1 }}
                    </span>
                    <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-semibold text-xs shrink-0">
                        {{ substr($entry->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium text-gray-900 group-hover:text-primary transition-colors truncate">{{ $entry->name }}</p>
                    </div>
                    <span class="inline-flex items-center gap-0.5 text-sm font-bold text-orange-500 shrink-0">
                        <span class="material-symbols-outlined text-[16px]">local_fire_department</span>
                        {{ $entry->current_streak }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Highest Execution Scores --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center gap-2 mb-5">
            <span class="material-symbols-outlined text-[20px] text-green-500">speed</span>
            <h3 class="text-sm font-semibold text-gray-900">Highest Execution Scores</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach ($highestScores as $index => $entry)
                <a href="{{ route('profiles.public', $entry) }}" class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-green-200 hover:bg-green-50/50 transition-all group relative">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold shrink-0
                        {{ $index === 0 ? 'bg-yellow-400 text-white' : ($index === 1 ? 'bg-gray-300 text-white' : ($index === 2 ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-500')) }}">
                        {{ $index + 1 }}
                    </span>
                    <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center font-semibold text-xs shrink-0">
                        {{ substr($entry->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium text-gray-900 group-hover:text-primary transition-colors truncate">{{ $entry->name }}</p>
                    </div>
                    <span class="inline-flex items-center gap-0.5 text-sm font-bold text-green-600 shrink-0">
                        <span class="material-symbols-outlined text-[16px]">stars</span>
                        {{ $entry->execution_score }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Most Tasks Completed --}}
    @if($mostTasksCompleted->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center gap-2 mb-5">
            <span class="material-symbols-outlined text-[20px] text-blue-500">checklist</span>
            <h3 class="text-sm font-semibold text-gray-900">Most Tasks Completed</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach ($mostTasksCompleted as $index => $entry)
                <a href="{{ route('profiles.public', $entry) }}" class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all group relative">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold shrink-0
                        {{ $index === 0 ? 'bg-yellow-400 text-white' : ($index === 1 ? 'bg-gray-300 text-white' : ($index === 2 ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-500')) }}">
                        {{ $index + 1 }}
                    </span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-semibold text-xs shrink-0">
                        {{ substr($entry->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium text-gray-900 group-hover:text-primary transition-colors truncate">{{ $entry->name }}</p>
                    </div>
                    <span class="inline-flex items-center gap-0.5 text-sm font-bold text-blue-600 shrink-0">
                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                        {{ $entry->tasks()->where('status', 'completed')->count() }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Challenge Winners --}}
    @if($challengeWinners->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center gap-2 mb-5">
            <span class="material-symbols-outlined text-[20px] text-primary">emoji_events</span>
            <h3 class="text-sm font-semibold text-gray-900">Challenge Winners</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach ($challengeWinners as $index => $entry)
                <a href="{{ route('profiles.public', $entry) }}" class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-yellow-200 hover:bg-yellow-50/50 transition-all group relative">
                    <div class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center font-semibold text-xs shrink-0">
                        <span class="material-symbols-outlined text-[16px]">emoji_events</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium text-gray-900 group-hover:text-primary transition-colors truncate">{{ $entry->name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Top Mentors --}}
    @if($mentors->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center gap-2 mb-5">
            <span class="material-symbols-outlined text-[20px] text-purple-500">school</span>
            <h3 class="text-sm font-semibold text-gray-900">Community Mentors</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach ($mentors as $mentor)
                <a href="{{ route('mentors.show', $mentor->user) }}" class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-purple-200 hover:bg-purple-50/50 transition-all group relative">
                    <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center font-semibold text-xs shrink-0 relative">
                        {{ substr($mentor->user->name, 0, 1) }}
                        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-purple-500 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-[8px] text-white">verified</span>
                        </span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium text-gray-900 group-hover:text-primary transition-colors truncate">{{ $mentor->user->name }}</p>
                        <p class="text-[10px] text-gray-400">{{ $mentor->mentees_count }} mentees</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
