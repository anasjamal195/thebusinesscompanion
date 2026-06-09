@php
    $title = 'Mentors';
    $pageTitle = 'Mentors';
    $activeNav = 'mentors';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="{ showApply: false }">
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Mentors</h2>
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

    <!-- CTA -->
    @if($canBecomeMentor && !$user->mentor)
        <button @click="showApply = !showApply" class="w-full bg-gradient-to-r from-primary/5 to-purple-500/5 rounded-[2rem] p-8 border-2 border-dashed border-primary/20 hover:border-primary/40 transition-all text-left">
            <div class="flex items-center gap-4">
                <span class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[32px]">school</span>
                </span>
                <div>
                    <h3 class="text-xl font-black text-gray-900">Become a Mentor</h3>
                    <p class="text-sm text-gray-500 font-medium">You meet the requirements! Share your experience and help others grow.</p>
                </div>
                <span class="ml-auto material-symbols-outlined text-primary">arrow_forward</span>
            </div>
        </button>

        <!-- Apply Form -->
        <div x-show="showApply" x-cloak class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
            <form action="{{ route('mentors.apply') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Your Bio</label>
                    <textarea name="bio" rows="4" required maxlength="2000" class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-primary focus:ring focus:ring-primary/20 font-semibold resize-none" placeholder="Tell the community about yourself and how you can help..."></textarea>
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Specialties (up to 5)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @php $specialtyOptions = ['Task Management', 'Productivity', 'Time Management', 'Goal Setting', 'Accountability', 'Deep Work', 'Procrastination', 'Work-Life Balance', 'Morning Routines', 'Project Planning']; @endphp
                        @foreach ($specialtyOptions as $option)
                            <label class="flex items-center gap-3 p-3 bg-gray-50 rounded-2xl border border-gray-100 cursor-pointer hover:border-primary/20 transition-colors">
                                <input type="checkbox" name="specialties[]" value="{{ $option }}" class="rounded-lg border-gray-300 text-primary focus:ring-primary/20">
                                <span class="text-sm font-bold text-gray-700">{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="px-8 py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95">
                    Apply to Become a Mentor
                </button>
            </form>
        </div>
    @endif

    <!-- Mentors Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($mentors as $mentor)
            <a href="{{ route('mentors.show', $mentor->user) }}" class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100 hover:border-primary/20 hover:shadow-2xl transition-all duration-300 group">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center font-black text-xl relative">
                        {{ substr($mentor->user->name, 0, 1) }}
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-purple-500 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-[12px] text-white">verified</span>
                        </span>
                    </div>
                    <div class="min-w-0">
                        <h4 class="font-bold text-gray-900 group-hover:text-primary transition-colors truncate">{{ $mentor->user->name }}</h4>
                        <p class="text-xs text-gray-400 font-bold">{{ $mentor->mentees_count }} mentee{{ $mentor->mentees_count !== 1 ? 's' : '' }}</p>
                    </div>
                </div>
                @if($mentor->bio)
                    <p class="text-sm text-gray-600 font-medium line-clamp-3">{{ $mentor->bio }}</p>
                @endif
                @if($mentor->specialties)
                    <div class="flex flex-wrap gap-2 mt-4">
                        @foreach ($mentor->specialties as $specialty)
                            <span class="text-[10px] font-bold text-purple-600 bg-purple-100 px-2.5 py-1 rounded-full">{{ $specialty }}</span>
                        @endforeach
                    </div>
                @endif
            </a>
        @empty
            <div class="col-span-full text-center py-16">
                <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">school</span>
                <h3 class="text-xl font-black text-gray-900 mb-2">No Mentors Yet</h3>
                <p class="text-gray-500 font-medium">The mentorship program is new. Be the first to apply!</p>
            </div>
        @endforelse
    </div>

    {{ $mentors->links() }}
</div>
@endsection
