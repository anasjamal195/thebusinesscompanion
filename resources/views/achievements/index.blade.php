@php
    $title = 'Achievements';
    $pageTitle = 'Achievements';
    $activeNav = 'achievements';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="{ shareModal: false, shareAchievement: null }">
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Achievements</h2>
        @if(session('success'))
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-xl text-sm font-bold border border-green-100">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-xl text-sm font-bold border border-red-100">
                <span class="material-symbols-outlined text-[18px]">error</span>
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Stats Strip -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-[2rem] p-6 shadow-lg shadow-gray-200/30 border border-gray-50 flex items-center gap-4">
            <span class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[28px]">emoji_events</span>
            </span>
            <div>
                <p class="text-2xl font-black text-gray-900">{{ $recentEarned->count() }}</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Recent Badges</p>
            </div>
        </div>
        <div class="bg-white rounded-[2rem] p-6 shadow-lg shadow-gray-200/30 border border-gray-50 flex items-center gap-4">
            <span class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[28px]">local_fire_department</span>
            </span>
            <div>
                <p class="text-2xl font-black text-gray-900">{{ $streak }}</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Day Streak</p>
            </div>
        </div>
        <div class="bg-white rounded-[2rem] p-6 shadow-lg shadow-gray-200/30 border border-gray-50 flex items-center gap-4">
            <span class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[28px]">speed</span>
            </span>
            <div>
                <p class="text-2xl font-black text-gray-900">{{ $executionScore }}</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Execution Score</p>
            </div>
        </div>
        <div class="bg-white rounded-[2rem] p-6 shadow-lg shadow-gray-200/30 border border-gray-50 flex items-center gap-4">
            <span class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[28px]">stars</span>
            </span>
            <div>
                <p class="text-2xl font-black text-gray-900">{{ count($earnedIds) }}</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Badges</p>
            </div>
        </div>
    </div>

    <!-- Achievement Categories -->
    @foreach ($allAchievements as $category => $achievements)
        <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
            <h3 class="text-xl font-black text-gray-900 tracking-tight capitalize mb-6 flex items-center gap-3">
                <span class="material-symbols-outlined text-[24px] text-primary">
                    @switch($category)
                        @case('tasks') checklist @break
                        @case('reports') summarize @break
                        @case('accountability') phone_in_talk @break
                        @case('consistency') local_fire_department @break
                        @case('completion') verified @break
                        @default emoji_events
                    @endswitch
                </span>
                {{ $category }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($achievements as $achievement)
                    @php $earned = in_array($achievement->id, $earnedIds); @endphp
                    <div class="relative rounded-2xl border-2 p-5 transition-all duration-200 {{ $earned ? 'border-primary/30 bg-primary/5' : 'border-gray-100 bg-gray-50/50 opacity-60' }}">
                        <div class="flex items-start justify-between mb-3">
                            <span class="w-10 h-10 rounded-xl flex items-center justify-center text-2xl" style="background: {{ $achievement->badge_color }}20; color: {{ $achievement->badge_color }}">
                                <span class="material-symbols-outlined">{{ $achievement->icon }}</span>
                            </span>
                            @if($earned)
                                <span class="text-[10px] font-black text-green-600 bg-green-100 px-2 py-1 rounded-full uppercase tracking-wider">Earned</span>
                            @endif
                        </div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">{{ $achievement->name }}</h4>
                        <p class="text-xs text-gray-500 font-medium">{{ $achievement->description }}</p>
                        @if($earned)
                            <div class="mt-3 flex gap-2">
                                <form action="{{ route('achievements.share', $achievement) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-bold text-primary hover:text-primary-container transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">share</span>
                                        Share
                                    </button>
                                </form>
                                <form action="{{ route('achievements.keep-private', $achievement) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">lock</span>
                                        Private
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection
