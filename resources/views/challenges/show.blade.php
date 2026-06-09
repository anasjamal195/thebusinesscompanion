@php
    $title = $challenge->name;
    $pageTitle = $challenge->name;
    $activeNav = 'challenges';
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <a href="{{ route('challenges.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-400 hover:text-gray-600 transition-colors">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
        Back to Challenges
    </a>

    @if(session('success'))
        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
            <span class="material-symbols-outlined text-[16px]">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Challenge Header --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center gap-5">
            <span class="w-16 h-16 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[36px]">{{ $challenge->icon }}</span>
            </span>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900">{{ $challenge->name }}</h2>
                <p class="text-sm text-gray-500 mt-1 leading-relaxed">{{ $challenge->description }}</p>
                <div class="flex flex-wrap items-center gap-4 mt-3 text-sm">
                    <span class="flex items-center gap-1 text-primary font-medium">
                        <span class="material-symbols-outlined text-[16px]">people</span>
                        {{ $participantCount }} participant{{ $participantCount !== 1 ? 's' : '' }}
                    </span>
                    <span class="flex items-center gap-1 text-gray-400">
                        <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                        {{ $challenge->start_date->format('M d, Y') }} - {{ $challenge->end_date->format('M d, Y') }}
                    </span>
                </div>
            </div>
            <div class="shrink-0">
                @if(!$userParticipation)
                    @if($challenge->end_date >= now()->toDateString())
                        <form action="{{ route('challenges.join', $challenge) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">flag</span>
                                Join Challenge
                            </button>
                        </form>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-500 font-medium rounded-lg text-sm">
                            Challenge Ended
                        </span>
                    @endif
                @else
                    <div class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-50 text-green-700 font-medium rounded-lg text-sm">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Participating
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Participants --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-primary">people</span>
            Participants
        </h3>
        @if($participants->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                @foreach ($participants as $participant)
                    <a href="{{ route('profiles.public', $participant->user) }}" class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-primary/20 hover:bg-primary/5 transition-all group">
                        <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-semibold text-sm">
                            {{ substr($participant->user->name, 0, 1) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-primary transition-colors">{{ $participant->user->name }}</p>
                            <p class="text-[11px] text-gray-400">{{ $participant->joined_at->diffForHumans() }}</p>
                        </div>
                        @if($participant->completed_at)
                            <span class="text-green-500">
                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 text-center py-6">No participants yet. Be the first to join!</p>
        @endif
    </div>
</div>
@endsection
