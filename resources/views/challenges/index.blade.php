@php
    $title = 'Challenges';
    $pageTitle = 'Challenges';
    $activeNav = 'challenges';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Challenges</h2>
            <p class="text-sm text-gray-500 mt-0.5">Join challenges to grow and compete with the community.</p>
        </div>
        @if(session('success'))
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
    </div>

    {{-- Active Challenges --}}
    @if($activeChallenges->isNotEmpty())
        <div>
            <div class="flex items-center gap-2 mb-4">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                <h3 class="text-sm font-semibold text-gray-900">Active Challenges</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($activeChallenges as $challenge)
                    <a href="{{ route('challenges.show', $challenge) }}" class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:border-gray-300 hover:shadow-md transition-all duration-200 group">
                        <span class="w-11 h-11 rounded-lg bg-primary/10 text-primary flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-[24px]">{{ $challenge->icon }}</span>
                        </span>
                        <h4 class="text-base font-semibold text-gray-900 mb-1 group-hover:text-primary transition-colors">{{ $challenge->name }}</h4>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $challenge->description }}</p>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-primary font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">people</span>
                                {{ $challenge->participants_count }} participants
                            </span>
                            <span class="text-gray-400">
                                {{ $challenge->start_date->format('M d') }} - {{ $challenge->end_date->format('M d, Y') }}
                            </span>
                        </div>
                        @if(isset($userParticipations[$challenge->id]))
                            <div class="mt-3 inline-flex items-center gap-1 px-2 py-0.5 bg-green-50 text-green-700 rounded-md text-[10px] font-semibold uppercase tracking-wider">
                                Joined
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm text-center py-12">
            <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">flag</span>
            <h3 class="text-base font-semibold text-gray-900 mb-1">No Active Challenges</h3>
            <p class="text-sm text-gray-500">New challenges will appear here. Stay tuned!</p>
        </div>
    @endif

    {{-- Past Challenges --}}
    @if($pastChallenges->isNotEmpty())
        <div class="mt-8">
            <h3 class="text-sm font-semibold text-gray-500 mb-4">Past Challenges</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($pastChallenges as $challenge)
                    <a href="{{ route('challenges.show', $challenge) }}" class="bg-white/50 rounded-xl border border-gray-200 shadow-sm p-5 hover:border-gray-300 transition-all duration-200 group opacity-60">
                        <span class="w-11 h-11 rounded-lg bg-gray-100 text-gray-400 flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-[24px]">{{ $challenge->icon }}</span>
                        </span>
                        <h4 class="text-base font-semibold text-gray-600 mb-1">{{ $challenge->name }}</h4>
                        <p class="text-xs text-gray-400">{{ $challenge->start_date->format('M d') }} - {{ $challenge->end_date->format('M d, Y') }}</p>
                        <span class="text-xs text-gray-400 flex items-center gap-1 mt-2">
                            <span class="material-symbols-outlined text-[14px]">people</span>
                            {{ $challenge->participants_count }} participants
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
