@php
    $title = $user->name . ' - Profile';
    $pageTitle = $user->name;
    $activeNav = 'profile';
    use Illuminate\Support\Str;

    $postTypeMeta = [
        'progress' => ['label' => 'Progress', 'icon' => 'trending_up', 'color' => 'bg-blue-50 text-blue-700'],
        'success_story' => ['label' => 'Success Story', 'icon' => 'emoji_events', 'color' => 'bg-purple-50 text-purple-700'],
        'milestone' => ['label' => 'Milestone', 'icon' => 'flag', 'color' => 'bg-green-50 text-green-700'],
        'achievement' => ['label' => 'Achievement', 'icon' => 'stars', 'color' => 'bg-yellow-50 text-yellow-700'],
        'challenge_result' => ['label' => 'Challenge', 'icon' => 'flag', 'color' => 'bg-orange-50 text-orange-700'],
        'tip' => ['label' => 'Tip', 'icon' => 'lightbulb', 'color' => 'bg-teal-50 text-teal-700'],
        'question' => ['label' => 'Question', 'icon' => 'help', 'color' => 'bg-indigo-50 text-indigo-700'],
    ];
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    @if(session('success'))
        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
            <span class="material-symbols-outlined text-[16px]">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Private Profile Notice --}}
    @if($user->community_participation_mode === 'private' && $authUser && $authUser->id !== $user->id && !$isFollowing)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 text-center">
            <div class="w-16 h-16 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-2xl mx-auto mb-4">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">This profile is private. Follow to see their content.</p>
            @if($authUser)
                <form action="{{ route('community.follow', $user) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">person_add</span>
                        Send Follow Request
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold shadow-sm mt-4">
                    Sign in to follow
                </a>
            @endif
        </div>
    @else
    {{-- Profile Header --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex flex-col md:flex-row items-start gap-5">
            <div class="w-16 h-16 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-2xl shrink-0">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    @if($mentorInfo && $mentorInfo->is_active)
                        <span class="inline-flex items-center gap-0.5 text-[10px] font-medium text-purple-600 bg-purple-100 px-1.5 py-0.5 rounded-md tracking-wider">
                            <span class="material-symbols-outlined text-[14px]">verified</span>
                            Mentor
                        </span>
                    @endif
                </div>
                <p class="text-sm text-gray-500 mt-0.5">Member since {{ $user->created_at->format('M Y') }}</p>
                @if($user->profile && $user->profile->business_name)
                    <p class="text-sm font-medium text-gray-700 mt-1">{{ $user->profile->business_name }}</p>
                @endif
                @if($mentorInfo && $mentorInfo->specialties)
                    <div class="flex flex-wrap gap-1 mt-2">
                        @foreach ($mentorInfo->specialties as $specialty)
                            <span class="text-[10px] font-medium text-purple-600 bg-purple-100 px-1.5 py-0.5 rounded">{{ $specialty }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="shrink-0">
                @if($authUser && $authUser->id !== $user->id)
                    <form action="{{ route('community.follow', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg {{ $isFollowing ? 'bg-gray-100 text-gray-700 border border-gray-200' : 'bg-primary text-white shadow-sm' }} text-sm font-semibold transition-all">
                            <span class="material-symbols-outlined text-[18px]">{{ $isFollowing ? 'person_remove' : 'person_add' }}</span>
                            {{ $isFollowing ? 'Following' : 'Follow' }}
                        </button>
                    </form>
                @elseif($authUser && $authUser->id === $user->id)
                    <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Profile
                    </a>
                @endif
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mt-6 pt-6 border-t border-gray-100">
            <div class="text-center p-3 bg-gray-50 rounded-lg">
                <p class="text-xl font-bold text-gray-900">{{ $streak }}</p>
                <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Day Streak</p>
            </div>
            <div class="text-center p-3 bg-gray-50 rounded-lg">
                <p class="text-xl font-bold text-gray-900">{{ $tasksCompleted }}</p>
                <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Tasks Done</p>
            </div>
            <div class="text-center p-3 bg-gray-50 rounded-lg">
                <p class="text-xl font-bold text-gray-900">{{ $reportsGenerated }}</p>
                <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Reports</p>
            </div>
            <div class="text-center p-3 bg-gray-50 rounded-lg">
                <p class="text-xl font-bold text-gray-900">{{ $callsAnswered }}</p>
                <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">AI Calls</p>
            </div>
            <div class="text-center p-3 bg-gray-50 rounded-lg">
                <p class="text-xl font-bold text-gray-900">{{ $totalPosts }}</p>
                <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Posts</p>
            </div>
        </div>
    </div>

    {{-- Scores --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-3">
                <span class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">speed</span>
                </span>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Execution Score</h3>
                    <p class="text-xs text-gray-500">Platform generated</p>
                </div>
            </div>
            <div class="flex items-end gap-1.5">
                <span class="text-3xl font-bold {{ $user->execution_score >= 80 ? 'text-green-600' : ($user->execution_score >= 50 ? 'text-yellow-600' : 'text-gray-600') }}">{{ $user->execution_score }}</span>
                <span class="text-sm font-medium text-gray-400 mb-1">/ 100</span>
            </div>
            <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                <div class="h-2 rounded-full transition-all duration-700 {{ $user->execution_score >= 80 ? 'bg-green-500' : ($user->execution_score >= 50 ? 'bg-yellow-500' : 'bg-gray-400') }}" style="width: {{ $user->execution_score }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-3">
                <span class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">group</span>
                </span>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Community Reputation</h3>
                    <p class="text-xs text-gray-500">Social engagement</p>
                </div>
            </div>
            <div class="flex items-end gap-1.5">
                <span class="text-3xl font-bold {{ $user->community_reputation >= 80 ? 'text-purple-600' : ($user->community_reputation >= 50 ? 'text-yellow-600' : 'text-gray-600') }}">{{ $user->community_reputation }}</span>
                <span class="text-sm font-medium text-gray-400 mb-1">/ 100</span>
            </div>
            <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                <div class="h-2 rounded-full transition-all duration-700 {{ $user->community_reputation >= 80 ? 'bg-purple-500' : ($user->community_reputation >= 50 ? 'bg-yellow-500' : 'bg-gray-400') }}" style="width: {{ $user->community_reputation }}%"></div>
            </div>
        </div>
    </div>

    {{-- Social Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-primary">people</span>
                Community
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-xl font-bold text-gray-900">{{ $followersCount }}</p>
                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Followers</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-xl font-bold text-gray-900">{{ $followingCount }}</p>
                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Following</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-yellow-500">emoji_events</span>
                Badges
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-xl font-bold text-gray-900">{{ $badgesEarned }}</p>
                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Total Earned</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-xl font-bold text-gray-900">{{ $sharedAchievements }}</p>
                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Shared</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Shared Achievements --}}
    @if($achievements->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-yellow-500">emoji_events</span>
            Achievements
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
            @foreach ($achievements as $achievement)
                <div class="text-center p-3 rounded-lg {{ $achievement->pivot->is_shared ? 'bg-primary/5 border border-primary/20' : 'bg-gray-50 border border-gray-100 opacity-50' }}">
                    <span class="w-9 h-9 rounded-lg flex items-center justify-center mx-auto mb-1.5" style="background: {{ $achievement->badge_color }}15; color: {{ $achievement->badge_color }}">
                        <span class="material-symbols-outlined text-[22px]">{{ $achievement->icon }}</span>
                    </span>
                    <p class="text-[10px] font-medium text-gray-700">{{ $achievement->name }}</p>
                    @if($achievement->pivot->is_shared)
                        <p class="text-[8px] font-semibold text-primary uppercase tracking-wider mt-0.5">Shared</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- All Posts --}}
    @if($allPosts->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-primary">forum</span>
            Posts ({{ $totalPosts }})
        </h3>
        <div class="space-y-4">
            @foreach ($allPosts as $post)
                <x-community-post
                    :post="$post"
                    :postTypeMeta="$postTypeMeta"
                    :user="$authUser"
                    :showActions="true"
                    :showFollow="false"
                    :interactive="false"
                />
            @endforeach
        </div>
        <div class="mt-4">
            {{ $allPosts->links() }}
        </div>
    </div>
    @endif
    @endif
</div>
@endsection
