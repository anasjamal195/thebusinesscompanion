@php
    $title = 'Followers';
    $pageTitle = 'Manage Followers';
    $activeNav = 'feed';
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto" x-data="{ tab: 'followers' }">
    {{-- Tabs --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="flex border-b border-gray-200">
            <button @click="tab = 'followers'" class="flex-1 px-4 py-3 text-sm font-semibold text-center transition-colors" :class="tab === 'followers' ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-gray-700'">
                Followers ({{ $acceptedFollowers->total() }})
            </button>
            <button @click="tab = 'pending'" class="flex-1 px-4 py-3 text-sm font-semibold text-center transition-colors" :class="tab === 'pending' ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-gray-700'">
                Pending Requests ({{ $pendingFollowers->count() }})
            </button>
            <button @click="tab = 'following'" class="flex-1 px-4 py-3 text-sm font-semibold text-center transition-colors" :class="tab === 'following' ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-gray-700'">
                Following ({{ $following->total() }})
            </button>
        </div>

        {{-- Followers Tab --}}
        <div x-show="tab === 'followers'" class="divide-y divide-gray-100">
            @forelse ($acceptedFollowers as $follower)
                <div class="flex items-center justify-between px-4 py-3">
                    <a href="{{ route('profiles.public', $follower) }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-semibold text-sm">
                            {{ substr($follower->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium text-gray-900 group-hover:text-primary transition-colors">{{ $follower->name }}</span>
                    </a>
                    <form action="{{ route('followers.remove', $follower) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-red-500 hover:text-red-600 transition-colors px-3 py-1.5 rounded-lg hover:bg-red-50">Remove</button>
                    </form>
                </div>
            @empty
                <div class="text-center py-12">
                    <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">person_remove</span>
                    <p class="text-sm text-gray-500">No followers yet.</p>
                </div>
            @endforelse

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $acceptedFollowers->links() }}
            </div>
        </div>

        {{-- Pending Requests Tab --}}
        <div x-show="tab === 'pending'" x-cloak class="divide-y divide-gray-100">
            @forelse ($pendingFollowers as $follow)
                <div class="flex items-center justify-between px-4 py-3">
                    <a href="{{ route('profiles.public', $follow->follower) }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-semibold text-sm">
                            {{ substr($follow->follower->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium text-gray-900 group-hover:text-primary transition-colors">{{ $follow->follower->name }}</span>
                    </a>
                    <div class="flex items-center gap-2">
                        <form action="{{ route('followers.accept', $follow) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-medium text-green-600 hover:text-green-700 transition-colors px-3 py-1.5 rounded-lg hover:bg-green-50 border border-green-200">Accept</button>
                        </form>
                        <form action="{{ route('followers.reject', $follow) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-medium text-red-500 hover:text-red-600 transition-colors px-3 py-1.5 rounded-lg hover:bg-red-50">Reject</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">person_add</span>
                    <p class="text-sm text-gray-500">No pending requests.</p>
                </div>
            @endforelse
        </div>

        {{-- Following Tab --}}
        <div x-show="tab === 'following'" x-cloak class="divide-y divide-gray-100">
            @forelse ($following as $followed)
                <div class="flex items-center justify-between px-4 py-3">
                    <a href="{{ route('profiles.public', $followed) }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-semibold text-sm">
                            {{ substr($followed->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium text-gray-900 group-hover:text-primary transition-colors">{{ $followed->name }}</span>
                    </a>
                    <form action="{{ route('community.follow', $followed) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-red-500 hover:text-red-600 transition-colors px-3 py-1.5 rounded-lg hover:bg-red-50">Unfollow</button>
                    </form>
                </div>
            @empty
                <div class="text-center py-12">
                    <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">person_add</span>
                    <p class="text-sm text-gray-500">Not following anyone yet.</p>
                </div>
            @endforelse

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $following->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
