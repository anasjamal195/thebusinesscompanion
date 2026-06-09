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
        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-orange-500">local_fire_department</span>
            Longest Streaks
        </h3>
        <div class="space-y-2">
            @foreach ($longestStreaks as $index => $entry)
                <a href="{{ route('profiles.public', $entry) }}" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-primary/20 hover:bg-primary/5 transition-all group">
                    <span class="w-7 text-center font-bold text-sm {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-amber-600' : 'text-gray-300')) }}">
                        {{ $index + 1 }}
                    </span>
                    <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-semibold text-sm">
                        {{ substr($entry->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 group-hover:text-primary transition-colors">{{ $entry->name }}</p>
                    </div>
                    <span class="text-base font-bold text-orange-500">{{ $entry->current_streak }}<span class="text-xs font-medium text-gray-400">d</span></span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Highest Execution Scores --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-green-500">speed</span>
            Highest Execution Scores
        </h3>
        <div class="space-y-2">
            @foreach ($highestScores as $index => $entry)
                <a href="{{ route('profiles.public', $entry) }}" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-primary/20 hover:bg-primary/5 transition-all group">
                    <span class="w-7 text-center font-bold text-sm {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-amber-600' : 'text-gray-300')) }}">
                        {{ $index + 1 }}
                    </span>
                    <div class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center font-semibold text-sm">
                        {{ substr($entry->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 group-hover:text-primary transition-colors">{{ $entry->name }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-base font-bold text-green-600">{{ $entry->execution_score }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Challenge Winners --}}
    @if($challengeWinners->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-primary">emoji_events</span>
            Challenge Winners
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
            @foreach ($challengeWinners as $entry)
                <a href="{{ route('profiles.public', $entry) }}" class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-primary/20 hover:bg-primary/5 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center font-semibold text-sm">
                        {{ substr($entry->name, 0, 1) }}
                    </div>
                    <p class="text-sm font-medium text-gray-900 group-hover:text-primary transition-colors">{{ $entry->name }}</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Top Mentors --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-purple-500">school</span>
            Community Mentors
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
            @foreach ($mentors as $mentor)
                <a href="{{ route('mentors.show', $mentor->user) }}" class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-primary/20 hover:bg-primary/5 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center font-semibold text-sm">
                        {{ substr($mentor->user->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 group-hover:text-primary transition-colors truncate">{{ $mentor->user->name }}</p>
                        <p class="text-[11px] text-gray-400">{{ $mentor->mentees_count }} mentees</p>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-purple-400">verified</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
