@php
    $title = 'Hall of Fame';
    $pageTitle = 'Hall of Fame';
    $activeNav = 'hall-of-fame';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Hall of Fame</h2>
    </div>

    <!-- Longest Streaks -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight mb-6 flex items-center gap-3">
            <span class="material-symbols-outlined text-[24px] text-orange-500">local_fire_department</span>
            Longest Streaks
        </h3>
        <div class="space-y-3">
            @foreach ($longestStreaks as $index => $entry)
                <a href="{{ route('profiles.public', $entry) }}" class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary/20 hover:bg-primary/5 transition-all group">
                    <span class="w-8 text-center font-black text-lg {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-amber-600' : 'text-gray-300')) }}">
                        {{ $index + 1 }}
                    </span>
                    <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                        {{ substr($entry->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-gray-900 group-hover:text-primary transition-colors">{{ $entry->name }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $entry->current_streak }} days</p>
                    </div>
                    <span class="text-lg font-black text-orange-500">{{ $entry->current_streak }}<span class="text-xs font-bold text-gray-400">d</span></span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Highest Execution Scores -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight mb-6 flex items-center gap-3">
            <span class="material-symbols-outlined text-[24px] text-green-500">speed</span>
            Highest Execution Scores
        </h3>
        <div class="space-y-3">
            @foreach ($highestScores as $index => $entry)
                <a href="{{ route('profiles.public', $entry) }}" class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary/20 hover:bg-primary/5 transition-all group">
                    <span class="w-8 text-center font-black text-lg {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-amber-600' : 'text-gray-300')) }}">
                        {{ $index + 1 }}
                    </span>
                    <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center font-bold text-sm">
                        {{ substr($entry->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-gray-900 group-hover:text-primary transition-colors">{{ $entry->name }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-lg font-black text-green-600">{{ $entry->execution_score }}</span>
                        <span class="text-[10px] font-bold text-gray-400 block">score</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Challenge Winners -->
    @if($challengeWinners->isNotEmpty())
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight mb-6 flex items-center gap-3">
            <span class="material-symbols-outlined text-[24px] text-primary">emoji_events</span>
            Challenge Winners
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($challengeWinners as $entry)
                <a href="{{ route('profiles.public', $entry) }}" class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary/20 hover:bg-primary/5 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold text-sm">
                        {{ substr($entry->name, 0, 1) }}
                    </div>
                    <p class="font-bold text-sm text-gray-900 group-hover:text-primary transition-colors">{{ $entry->name }}</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Top Mentors -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight mb-6 flex items-center gap-3">
            <span class="material-symbols-outlined text-[24px] text-purple-500">school</span>
            Community Mentors
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($mentors as $mentor)
                <a href="{{ route('mentors.show', $mentor->user) }}" class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary/20 hover:bg-primary/5 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-sm">
                        {{ substr($mentor->user->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-sm text-gray-900 group-hover:text-primary transition-colors truncate">{{ $mentor->user->name }}</p>
                        <p class="text-[10px] font-bold text-gray-400">{{ $mentor->mentees_count }} mentees</p>
                    </div>
                    <span class="material-symbols-outlined text-[18px] text-purple-400">verified</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
