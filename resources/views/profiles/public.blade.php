@php
    $title = $user->name . ' - Profile';
    $pageTitle = $user->name;
    $activeNav = 'profile';
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    @if(session('success'))
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-xl text-sm font-bold border border-green-100">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- Profile Header -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100">
        <div class="flex flex-col md:flex-row items-start gap-6">
            <div class="w-20 h-20 rounded-[2rem] bg-primary/10 text-primary flex items-center justify-center font-black text-3xl shrink-0">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-3 flex-wrap">
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">{{ $user->name }}</h2>
                    @if($user->mentor && $user->mentor->is_active)
                        <span class="flex items-center gap-1 text-[10px] font-black text-purple-600 bg-purple-100 px-2.5 py-1 rounded-full uppercase tracking-wider">
                            <span class="material-symbols-outlined text-[14px]">verified</span>
                            Mentor
                        </span>
                    @endif
                </div>
                <p class="text-gray-500 font-medium mt-1">Member since {{ $user->created_at->format('M Y') }}</p>
                @if($user->profile && $user->profile->business_name)
                    <p class="text-sm font-bold text-gray-700 mt-1">{{ $user->profile->business_name }}</p>
                @endif
            </div>
            <div class="shrink-0">
                @if($authUser && $authUser->id !== $user->id)
                    <form action="{{ route('community.follow', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 {{ $isFollowing ? 'bg-gray-100 text-gray-700 border-gray-200' : 'bg-primary text-white shadow-lg shadow-primary/20' }} font-bold rounded-2xl border transition-all active:scale-95 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">{{ $isFollowing ? 'person_remove' : 'person_add' }}</span>
                            {{ $isFollowing ? 'Following' : 'Follow' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8 pt-8 border-t border-gray-100">
            <div class="text-center p-4 bg-gray-50 rounded-2xl">
                <p class="text-2xl font-black text-gray-900">{{ $streak }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Day Streak</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-2xl">
                <p class="text-2xl font-black text-gray-900">{{ $tasksCompleted }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tasks Done</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-2xl">
                <p class="text-2xl font-black text-gray-900">{{ $reportsGenerated }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Reports</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-2xl">
                <p class="text-2xl font-black text-gray-900">{{ $callsAnswered }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">AI Calls</p>
            </div>
        </div>
    </div>

    <!-- Scores -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
            <div class="flex items-center gap-3 mb-4">
                <span class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">speed</span>
                </span>
                <div>
                    <h3 class="font-black text-gray-900">Execution Score</h3>
                    <p class="text-xs text-gray-500 font-medium">Platform generated</p>
                </div>
            </div>
            <div class="flex items-end gap-2">
                <span class="text-5xl font-black {{ $user->execution_score >= 80 ? 'text-green-600' : ($user->execution_score >= 50 ? 'text-yellow-600' : 'text-gray-600') }}">{{ $user->execution_score }}</span>
                <span class="text-lg font-bold text-gray-400 mb-1">/ 100</span>
            </div>
            <div class="mt-4 w-full bg-gray-100 rounded-full h-2">
                <div class="h-2 rounded-full transition-all duration-700 {{ $user->execution_score >= 80 ? 'bg-green-500' : ($user->execution_score >= 50 ? 'bg-yellow-500' : 'bg-gray-400') }}" style="width: {{ $user->execution_score }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
            <div class="flex items-center gap-3 mb-4">
                <span class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">group</span>
                </span>
                <div>
                    <h3 class="font-black text-gray-900">Community Reputation</h3>
                    <p class="text-xs text-gray-500 font-medium">Social engagement</p>
                </div>
            </div>
            <div class="flex items-end gap-2">
                <span class="text-5xl font-black {{ $user->community_reputation >= 80 ? 'text-purple-600' : ($user->community_reputation >= 50 ? 'text-yellow-600' : 'text-gray-600') }}">{{ $user->community_reputation }}</span>
                <span class="text-lg font-bold text-gray-400 mb-1">/ 100</span>
            </div>
            <div class="mt-4 w-full bg-gray-100 rounded-full h-2">
                <div class="h-2 rounded-full transition-all duration-700 {{ $user->community_reputation >= 80 ? 'bg-purple-500' : ($user->community_reputation >= 50 ? 'bg-yellow-500' : 'bg-gray-400') }}" style="width: {{ $user->community_reputation }}%"></div>
            </div>
        </div>
    </div>

    <!-- Social Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
            <h3 class="text-lg font-black text-gray-900 tracking-tight mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[22px] text-primary">people</span>
                Community
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-4 bg-gray-50 rounded-2xl">
                    <p class="text-2xl font-black text-gray-900">{{ $followersCount }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Followers</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-2xl">
                    <p class="text-2xl font-black text-gray-900">{{ $followingCount }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Following</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
            <h3 class="text-lg font-black text-gray-900 tracking-tight mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[22px] text-yellow-500">emoji_events</span>
                Badges
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-4 bg-gray-50 rounded-2xl">
                    <p class="text-2xl font-black text-gray-900">{{ $badgesEarned }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Earned</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-2xl">
                    <p class="text-2xl font-black text-gray-900">{{ $sharedAchievements }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Shared</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Shared Achievements -->
    @if($achievements->isNotEmpty())
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined text-[24px] text-yellow-500">emoji_events</span>
            Achievements
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach ($achievements as $achievement)
                <div class="text-center p-4 rounded-2xl {{ $achievement->pivot->is_shared ? 'bg-primary/5 border border-primary/20' : 'bg-gray-50 border border-gray-100 opacity-50' }}">
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-2 text-2xl" style="background: {{ $achievement->badge_color }}20; color: {{ $achievement->badge_color }}">
                        <span class="material-symbols-outlined">{{ $achievement->icon }}</span>
                    </span>
                    <p class="text-[10px] font-bold text-gray-700">{{ $achievement->name }}</p>
                    @if($achievement->pivot->is_shared)
                        <p class="text-[8px] font-bold text-primary uppercase tracking-wider mt-1">Shared</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Recent Posts -->
    @if($recentPosts->isNotEmpty())
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined text-[24px] text-primary">forum</span>
            Recent Activity
        </h3>
        <div class="space-y-4">
            @foreach ($recentPosts as $post)
                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full {{ $post->type === 'achievement' ? 'bg-yellow-100 text-yellow-700' : ($post->type === 'success_story' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700') }}">
                            {{ $post->type }}
                        </span>
                        <span class="text-[10px] font-bold text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-700 font-medium">{{ Str::limit($post->content, 200) }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
