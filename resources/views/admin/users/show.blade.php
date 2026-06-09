@extends('admin.layouts.app', ['title' => $user->name, 'activeNav' => 'users', 'pageTitle' => $user->name])

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="rounded-xl border border-gray-200 bg-white p-6 text-center">
            <div class="h-16 w-16 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-2xl mx-auto mb-4">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h2 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h2>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
            <div class="mt-4 inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700' : 'bg-gray-50 text-gray-600' }}">
                {{ $user->role ?? 'user' }}
            </div>
            <div class="mt-6 space-y-3 text-left">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Credits</span>
                    <span class="font-semibold text-gray-900">{{ number_format($user->credits, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Calls</span>
                    <span class="font-semibold text-gray-900">{{ $user->calls_count }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Member Since</span>
                    <span class="font-semibold text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="rounded-xl border border-gray-200 bg-white p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Calls</h3>
            <div class="space-y-3">
                @forelse($user->calls as $call)
                    <div class="flex items-center gap-4 py-3 border-b border-gray-200 last:border-0">
                        <div class="h-10 w-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">call</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-semibold text-gray-900">{{ $call->status ?? 'Call' }}</div>
                            <div class="text-xs text-gray-500">{{ $call->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $call->status === 'completed' ? 'bg-green-50 text-green-700' : ($call->status === 'missed' ? 'bg-red-50 text-red-700' : 'bg-gray-50 text-gray-600') }}">
                            {{ $call->status ?? 'unknown' }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-8">No calls yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
