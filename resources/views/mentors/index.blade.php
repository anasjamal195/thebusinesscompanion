@php
    $title = 'Mentors';
    $pageTitle = 'Mentors';
    $activeNav = 'mentors';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ showApply: false }">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Mentors</h2>
            <p class="text-sm text-gray-500 mt-0.5">Learn from experienced community members.</p>
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

    {{-- Become a Mentor CTA --}}
    @if($canBecomeMentor && !$user->mentor)
        <button @click="showApply = !showApply" class="w-full bg-white rounded-xl border-2 border-dashed border-primary/20 hover:border-primary/40 transition-all p-5 text-left">
            <div class="flex items-center gap-4">
                <span class="w-12 h-12 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px]">school</span>
                </span>
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-gray-900">Become a Mentor</h3>
                    <p class="text-sm text-gray-500">You meet the requirements! Share your experience and help others grow.</p>
                </div>
                <span class="material-symbols-outlined text-primary text-[24px]">arrow_forward</span>
            </div>
        </button>

        {{-- Apply Form --}}
        <div x-show="showApply" x-cloak class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <form action="{{ route('mentors.apply') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Your Bio</label>
                    <textarea name="bio" rows="4" required maxlength="2000" class="w-full rounded-lg border-gray-200 bg-gray-50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm resize-none" placeholder="Tell the community about yourself..."></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Specialties (up to 5)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @php $specialtyOptions = ['Task Management', 'Productivity', 'Time Management', 'Goal Setting', 'Accountability', 'Deep Work', 'Procrastination', 'Work-Life Balance', 'Morning Routines', 'Project Planning']; @endphp
                        @foreach ($specialtyOptions as $option)
                            <label class="flex items-center gap-2.5 p-2.5 bg-gray-50 rounded-lg border border-gray-100 cursor-pointer hover:border-primary/20 transition-colors">
                                <input type="checkbox" name="specialties[]" value="{{ $option }}" class="rounded border-gray-300 text-primary focus:ring-primary/20">
                                <span class="text-sm font-medium text-gray-700">{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                    Apply to Become a Mentor
                </button>
            </form>
        </div>
    @endif

    {{-- Mentors Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($mentors as $mentor)
            <a href="{{ route('mentors.show', $mentor->user) }}" class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:border-gray-300 hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-lg relative">
                        {{ substr($mentor->user->name, 0, 1) }}
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-purple-500 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-[10px] text-white">verified</span>
                        </span>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-sm font-semibold text-gray-900 group-hover:text-primary transition-colors truncate">{{ $mentor->user->name }}</h4>
                        <p class="text-xs text-gray-400 font-medium">{{ $mentor->mentees_count }} mentee{{ $mentor->mentees_count !== 1 ? 's' : '' }}</p>
                    </div>
                </div>
                @if($mentor->bio)
                    <p class="text-sm text-gray-600 line-clamp-2">{{ $mentor->bio }}</p>
                @endif
                @if($mentor->specialties)
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        @foreach (array_slice($mentor->specialties, 0, 3) as $specialty)
                            <span class="text-[10px] font-medium text-purple-600 bg-purple-100 px-2 py-0.5 rounded-md">{{ $specialty }}</span>
                        @endforeach
                        @if(count($mentor->specialties) > 3)
                            <span class="text-[10px] font-medium text-gray-400">+{{ count($mentor->specialties) - 3 }}</span>
                        @endif
                    </div>
                @endif
            </a>
        @empty
            <div class="col-span-full text-center py-12">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">school</span>
                <h3 class="text-base font-semibold text-gray-900 mb-1">No Mentors Yet</h3>
                <p class="text-sm text-gray-500">Be the first to apply!</p>
            </div>
        @endforelse
    </div>

    {{ $mentors->links() }}
</div>
@endsection
