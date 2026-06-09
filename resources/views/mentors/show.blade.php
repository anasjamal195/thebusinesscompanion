@php
    $title = $mentor->user->name . ' - Mentor';
    $pageTitle = $mentor->user->name;
    $activeNav = 'mentors';
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <a href="{{ route('mentors.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-400 hover:text-gray-600 transition-colors">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
        Back to Mentors
    </a>

    {{-- Mentor Profile --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex flex-col md:flex-row items-start gap-5">
            <div class="w-16 h-16 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-2xl relative shrink-0">
                {{ substr($mentor->user->name, 0, 1) }}
                <span class="absolute -top-1.5 -right-1.5 w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-[14px] text-white">verified</span>
                </span>
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900">{{ $mentor->user->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs font-medium text-purple-600 bg-purple-100 px-2 py-0.5 rounded-md">Community Mentor</span>
                    <span class="text-xs text-gray-400">{{ $mentor->mentees_count }} mentee{{ $mentor->mentees_count !== 1 ? 's' : '' }}</span>
                </div>
            </div>
        </div>

        @if($mentor->bio)
            <div class="mt-5 pt-5 border-t border-gray-100">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">About</h3>
                <p class="text-sm text-gray-700 leading-relaxed">{{ $mentor->bio }}</p>
            </div>
        @endif

        @if($mentor->specialties)
            <div class="mt-5 pt-5 border-t border-gray-100">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Specialties</h3>
                <div class="flex flex-wrap gap-1.5">
                    @foreach ($mentor->specialties as $specialty)
                        <span class="text-xs font-medium text-purple-600 bg-purple-100 px-2.5 py-1 rounded-md">{{ $specialty }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-5 pt-5 border-t border-gray-100">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Community Stats</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-xl font-bold text-gray-900">{{ $mentor->user->execution_score }}</p>
                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Score</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-xl font-bold text-gray-900">{{ $mentor->user->community_reputation }}</p>
                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Reputation</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-xl font-bold text-gray-900">{{ $mentor->user->followers()->count() }}</p>
                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Followers</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-xl font-bold text-gray-900">{{ $mentor->user->achievements()->count() }}</p>
                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Badges</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Posts --}}
    @if($mentorPosts->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Recent Community Posts</h3>
        <div class="space-y-3">
            @foreach ($mentorPosts as $post)
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded {{ $post->type === 'achievement' ? 'bg-yellow-50 text-yellow-700' : 'bg-blue-50 text-blue-700' }}">
                            {{ $post->type }}
                        </span>
                        <span class="text-[11px] text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-700">{{ Str::limit($post->content, 200) }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="flex justify-center">
        <a href="{{ route('profiles.public', $mentor->user) }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
            View Full Profile
        </a>
    </div>
</div>
@endsection
