@php
    $title = $challenge->name;
    $pageTitle = $challenge->name;
    $activeNav = 'challenges';
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <a href="{{ route('challenges.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Back to Challenges
    </a>

    @if(session('success'))
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-xl text-sm font-bold border border-green-100">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- Challenge Header -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center gap-6">
            <span class="w-20 h-20 rounded-[2rem] bg-primary/10 text-primary flex items-center justify-center text-5xl shrink-0">
                <span class="material-symbols-outlined" style="font-size: 48px">{{ $challenge->icon }}</span>
            </span>
            <div class="flex-1">
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">{{ $challenge->name }}</h2>
                <p class="text-gray-500 font-medium mt-2 leading-relaxed">{{ $challenge->description }}</p>
                <div class="flex flex-wrap items-center gap-4 mt-4 text-sm font-bold">
                    <span class="flex items-center gap-1 text-primary">
                        <span class="material-symbols-outlined text-[18px]">people</span>
                        {{ $participantCount }} participant{{ $participantCount !== 1 ? 's' : '' }}
                    </span>
                    <span class="flex items-center gap-1 text-gray-400">
                        <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                        {{ $challenge->start_date->format('M d, Y') }} - {{ $challenge->end_date->format('M d, Y') }}
                    </span>
                </div>
            </div>
            <div class="shrink-0">
                @if(!$userParticipation)
                    @if($challenge->end_date >= now()->toDateString())
                        <form action="{{ route('challenges.join', $challenge) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-8 py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[22px]">flag</span>
                                Join Challenge
                            </button>
                        </form>
                    @else
                        <span class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-400 font-bold rounded-2xl text-sm">
                            Challenge Ended
                        </span>
                    @endif
                @else
                    <div class="inline-flex items-center gap-2 px-6 py-3 bg-green-100 text-green-700 font-bold rounded-2xl">
                        <span class="material-symbols-outlined text-[22px]">check_circle</span>
                        Participating
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Participants -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined text-[24px] text-primary">people</span>
            Participants
        </h3>
        @if($participants->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($participants as $participant)
                    <a href="{{ route('profiles.public', $participant->user) }}" class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary/20 hover:bg-primary/5 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                            {{ substr($participant->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-sm text-gray-900 group-hover:text-primary transition-colors">{{ $participant->user->name }}</p>
                            <p class="text-[10px] font-bold text-gray-400">{{ $participant->joined_at->diffForHumans() }}</p>
                        </div>
                        @if($participant->completed_at)
                            <span class="ml-auto text-green-500">
                                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 font-medium text-center py-8">No participants yet. Be the first to join!</p>
        @endif
    </div>
</div>
@endsection
