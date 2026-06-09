@extends('admin.layouts.app', ['title' => 'Admin Dashboard', 'activeNav' => 'dashboard', 'pageTitle' => 'Dashboard'])

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-[24px]">group</span>
            </div>
            <div>
                <div class="text-xl font-bold text-gray-900">{{ number_format($total_users) }}</div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Users</div>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 text-green-600">
                <span class="material-symbols-outlined text-[24px]">call</span>
            </div>
            <div>
                <div class="text-xl font-bold text-gray-900">{{ number_format($total_calls) }}</div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Calls</div>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                <span class="material-symbols-outlined text-[24px]">list_alt</span>
            </div>
            <div>
                <div class="text-xl font-bold text-gray-900">{{ number_format($total_waitlist) }}</div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Waitlist</div>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                <span class="material-symbols-outlined text-[24px]">payments</span>
            </div>
            <div>
                <div class="text-xl font-bold text-gray-900">${{ number_format($total_revenue, 2) }}</div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-semibold text-gray-900 mb-4">Recent Users</h2>
        <div class="space-y-2">
            @forelse($recent_users as $user)
                <div class="flex items-center gap-3 py-2 border-b border-gray-50 last:border-0">
                    <div class="h-9 w-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-semibold text-sm">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ $user->email }}</div>
                    </div>
                    <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <p class="text-sm text-gray-500">No users yet.</p>
            @endforelse
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-semibold text-gray-900 mb-4">Recent Purchases</h2>
        <div class="space-y-2">
            @forelse($recent_purchases as $purchase)
                <div class="flex items-center gap-3 py-2 border-b border-gray-50 last:border-0">
                    <div class="h-9 w-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">payments</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-medium text-gray-900 truncate">{{ $purchase->user->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-gray-500">${{ number_format($purchase->amount, 2) }} — {{ $purchase->credits_added }} credits</div>
                    </div>
                    <div class="text-xs text-gray-400">{{ $purchase->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <p class="text-sm text-gray-500">No purchases yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
