@php
    $title = 'Challenges';
    $pageTitle = 'Challenges';
    $activeNav = 'challenges';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Challenges</h2>
        @if(session('success'))
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-xl text-sm font-bold border border-green-100">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- Active Challenges -->
    @if($activeChallenges->isNotEmpty())
        <h3 class="text-xl font-black text-gray-900 tracking-tight flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-green-500"></span>
            Active Challenges
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($activeChallenges as $challenge)
                <a href="{{ route('challenges.show', $challenge) }}" class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100 hover:border-primary/20 hover:shadow-2xl transition-all duration-300 group block">
                    <span class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-4 text-3xl">
                        <span class="material-symbols-outlined">{{ $challenge->icon }}</span>
                    </span>
                    <h4 class="text-lg font-black text-gray-900 mb-2 group-hover:text-primary transition-colors">{{ $challenge->name }}</h4>
                    <p class="text-sm text-gray-500 font-medium mb-4 line-clamp-2">{{ $challenge->description }}</p>
                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="text-primary flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">people</span>
                            {{ $challenge->participants_count }} participants
                        </span>
                        <span class="text-gray-400">
                            {{ $challenge->start_date->format('M d') }} - {{ $challenge->end_date->format('M d, Y') }}
                        </span>
                    </div>
                    @if(isset($userParticipations[$challenge->id]))
                        <div class="mt-4 inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase tracking-widest">
                            Joined
                        </div>
                    @endif
                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-[2.5rem] p-12 text-center shadow-xl shadow-gray-200/50 border border-gray-100">
            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">flag</span>
            <h3 class="text-xl font-black text-gray-900 mb-2">No Active Challenges</h3>
            <p class="text-gray-500 font-medium">New challenges will appear here. Stay tuned!</p>
        </div>
    @endif

    <!-- Past Challenges -->
    @if($pastChallenges->isNotEmpty())
        <h3 class="text-xl font-black text-gray-900 tracking-tight text-gray-500 mt-12">Past Challenges</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($pastChallenges as $challenge)
                <a href="{{ route('challenges.show', $challenge) }}" class="bg-white/50 rounded-[2.5rem] p-8 shadow-lg shadow-gray-200/30 border border-gray-100 hover:border-gray-200 transition-all duration-300 group block opacity-70">
                    <span class="w-14 h-14 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center mb-4 text-3xl">
                        <span class="material-symbols-outlined">{{ $challenge->icon }}</span>
                    </span>
                    <h4 class="text-lg font-black text-gray-700 mb-2">{{ $challenge->name }}</h4>
                    <p class="text-sm text-gray-400 font-medium">{{ $challenge->start_date->format('M d') }} - {{ $challenge->end_date->format('M d, Y') }}</p>
                    <span class="text-xs font-bold text-gray-400 flex items-center gap-1 mt-2">
                        <span class="material-symbols-outlined text-[16px]">people</span>
                        {{ $challenge->participants_count }} participants
                    </span>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
