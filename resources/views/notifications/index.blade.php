@php
    $title = 'Notifications';
    $pageTitle = 'Notifications';
    $activeNav = 'feed';
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-900">Notifications</h2>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm divide-y divide-gray-100">
        @forelse ($notifications as $notification)
            <div class="px-4 py-4 flex items-start gap-3 {{ $notification->read_at ? '' : 'bg-primary/5' }}">
                <div class="w-9 h-9 rounded-lg {{ $notification->read_at ? 'bg-gray-100 text-gray-500' : 'bg-primary/10 text-primary' }} flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[20px]">
                        @switch($notification->type)
                            @case('follow_request')
                                person_add
                                @break
                            @default
                                notifications
                        @endswitch
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                    <p class="text-sm text-gray-600 mt-0.5">{{ $notification->message }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                @if(!$notification->read_at)
                    <form action="{{ route('notifications.read', $notification) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-primary hover:text-primary-container transition-colors px-2 py-1 rounded hover:bg-blue-50">Mark read</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="text-center py-12">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">notifications</span>
                <h3 class="text-base font-semibold text-gray-900 mb-1">No notifications</h3>
                <p class="text-sm text-gray-500">You're all caught up!</p>
            </div>
        @endforelse
    </div>

    <div class="py-2">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
