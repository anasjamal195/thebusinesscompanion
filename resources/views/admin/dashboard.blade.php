@extends('admin.layouts.app', ['title' => 'Admin Dashboard', 'activeNav' => 'dashboard', 'pageTitle' => 'Dashboard'])

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-[28px]">group</span>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-gray-900">{{ number_format($total_users) }}</div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Users</div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600">
                <span class="material-symbols-outlined text-[28px]">call</span>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-gray-900">{{ number_format($total_calls) }}</div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Calls</div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                <span class="material-symbols-outlined text-[28px]">list_alt</span>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-gray-900">{{ number_format($total_waitlist) }}</div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Waitlist Entries</div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <span class="material-symbols-outlined text-[28px]">payments</span>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-gray-900">${{ number_format($total_revenue, 2) }}</div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Revenue</div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <h2 class="text-lg font-extrabold text-gray-900 mb-4">Recent Users</h2>
        <div class="space-y-3">
            @forelse($recent_users as $user)
                <div class="flex items-center gap-3 py-2 border-b border-gray-50 last:border-0">
                    <div class="h-10 w-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-bold text-gray-900 truncate">{{ $user->name }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ $user->email }}</div>
                    </div>
                    <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <p class="text-sm text-gray-500">No users yet.</p>
            @endforelse
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <h2 class="text-lg font-extrabold text-gray-900 mb-4">Recent Purchases</h2>
        <div class="space-y-3">
            @forelse($recent_purchases as $purchase)
                <div class="flex items-center gap-3 py-2 border-b border-gray-50 last:border-0">
                    <div class="h-10 w-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]">payments</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-bold text-gray-900 truncate">{{ $purchase->user->name ?? 'Unknown' }}</div>
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
