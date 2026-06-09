@php
    $title = $mentor->user->name . ' - Mentor';
    $pageTitle = $mentor->user->name;
    $activeNav = 'mentors';
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <a href="{{ route('mentors.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Back to Mentors
    </a>

    <!-- Mentor Profile -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100">
        <div class="flex flex-col md:flex-row items-start gap-6">
            <div class="w-20 h-20 rounded-[2rem] bg-purple-100 text-purple-600 flex items-center justify-center font-black text-3xl relative shrink-0">
                {{ substr($mentor->user->name, 0, 1) }}
                <span class="absolute -top-2 -right-2 w-7 h-7 bg-purple-500 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-[16px] text-white">verified</span>
                </span>
            </div>
            <div class="flex-1">
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">{{ $mentor->user->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs font-black text-purple-600 bg-purple-100 px-3 py-1 rounded-full uppercase tracking-wider">Community Mentor</span>
                    <span class="text-xs font-bold text-gray-400">{{ $mentor->mentees_count }} mentee{{ $mentor->mentees_count !== 1 ? 's' : '' }}</span>
                </div>
            </div>
        </div>

        @if($mentor->bio)
            <div class="mt-8 pt-8 border-t border-gray-100">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">About</h3>
                <p class="text-gray-700 font-medium leading-relaxed">{{ $mentor->bio }}</p>
            </div>
        @endif

        @if($mentor->specialties)
            <div class="mt-6 pt-6 border-t border-gray-100">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Specialties</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($mentor->specialties as $specialty)
                        <span class="text-xs font-bold text-purple-600 bg-purple-100 px-3 py-1.5 rounded-full">{{ $specialty }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-6 pt-6 border-t border-gray-100">
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Community Stats</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-gray-50 rounded-2xl">
                    <p class="text-2xl font-black text-gray-900">{{ $mentor->user->execution_score }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Execution Score</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-2xl">
                    <p class="text-2xl font-black text-gray-900">{{ $mentor->user->community_reputation }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Reputation</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-2xl">
                    <p class="text-2xl font-black text-gray-900">{{ $mentor->user->followers()->count() }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Followers</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-2xl">
                    <p class="text-2xl font-black text-gray-900">{{ $mentor->user->achievements()->count() }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Badges</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts -->
    @if($mentorPosts->isNotEmpty())
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight mb-6">Recent Community Posts</h3>
        <div class="space-y-4">
            @foreach ($mentorPosts as $post)
                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full {{ $post->type === 'achievement' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
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

    <div class="flex justify-center">
        <a href="{{ route('profiles.public', $mentor->user) }}" class="px-8 py-4 bg-primary/5 text-primary font-bold rounded-2xl border-2 border-primary/20 hover:border-primary hover:bg-primary/10 transition-all">
            View Full Profile
        </a>
    </div>
</div>
@endsection
