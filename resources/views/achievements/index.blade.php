@php
    $title = 'Achievements';
    $pageTitle = 'Achievements';
    $activeNav = 'achievements';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ shareModal: false, shareAchievement: null }">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Achievements</h2>
            <p class="text-sm text-gray-500 mt-0.5">Badges and milestones you've earned.</p>
        </div>
        @if(session('success'))
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-sm font-medium border border-red-200">
                <span class="material-symbols-outlined text-[16px]">error</span>
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Stats Strip --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-3">
            <span class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">emoji_events</span>
            </span>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $recentEarned->count() }}</p>
                <p class="text-xs text-gray-500">Recent Badges</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-3">
            <span class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">local_fire_department</span>
            </span>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $streak }}</p>
                <p class="text-xs text-gray-500">Day Streak</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-3">
            <span class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">speed</span>
            </span>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $executionScore }}</p>
                <p class="text-xs text-gray-500">Execution Score</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-3">
            <span class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">stars</span>
            </span>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ count($earnedIds) }}</p>
                <p class="text-xs text-gray-500">Total Badges</p>
            </div>
        </div>
    </div>

    {{-- Achievement Categories --}}
    @foreach ($allAchievements as $category => $achievements)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 capitalize mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-primary">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                @foreach ($achievements as $achievement)
                    @php $earned = in_array($achievement->id, $earnedIds); @endphp
                    <div class="rounded-lg border p-4 transition-all duration-200 {{ $earned ? 'border-primary/30 bg-primary/5' : 'border-gray-100 bg-gray-50 opacity-60' }}">
                        <div class="flex items-start justify-between mb-2">
                            <span class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: {{ $achievement->badge_color }}15; color: {{ $achievement->badge_color }}">
                                <span class="material-symbols-outlined text-[22px]">{{ $achievement->icon }}</span>
                            </span>
                            @if($earned)
                                <span class="text-[10px] font-semibold text-green-600 bg-green-100 px-1.5 py-0.5 rounded-md">Earned</span>
                            @endif
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-1">{{ $achievement->name }}</h4>
                        <p class="text-xs text-gray-500">{{ $achievement->description }}</p>
                        @if($earned)
                            <div class="mt-3 flex gap-2">
                                <form action="{{ route('achievements.share', $achievement) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-medium text-primary hover:text-primary-container transition-colors flex items-center gap-0.5">
                                        <span class="material-symbols-outlined text-[14px]">share</span>
                                        Share
                                    </button>
                                </form>
                                <form action="{{ route('achievements.keep-private', $achievement) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-medium text-gray-400 hover:text-gray-600 transition-colors flex items-center gap-0.5">
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
