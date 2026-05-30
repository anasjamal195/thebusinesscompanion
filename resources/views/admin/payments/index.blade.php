@extends('admin.layouts.app', ['title' => 'Payments', 'activeNav' => 'payments', 'pageTitle' => 'Payments'])

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600">
                <span class="material-symbols-outlined text-[28px]">payments</span>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-gray-900">${{ number_format($total_revenue, 2) }}</div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Revenue</div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600">
                <span class="material-symbols-outlined text-[28px]">money_off</span>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-gray-900">${{ number_format($total_refunds, 2) }}</div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Refunds</div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <span class="material-symbols-outlined text-[28px]">hourglass_empty</span>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-gray-900">{{ number_format($pending_count) }}</div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pending</div>
            </div>
        </div>
    </div>
</div>

<div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">User</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Credits</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Session</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($purchases as $purchase)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                    {{ substr($purchase->user->name ?? '?', 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $purchase->user->name ?? 'Deleted User' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">${{ number_format($purchase->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ number_format($purchase->credits_added, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold
                                {{ $purchase->status === 'completed' ? 'bg-green-50 text-green-700' : '' }}
                                {{ $purchase->status === 'pending' ? 'bg-amber-50 text-amber-700' : '' }}
                                {{ $purchase->status === 'refunded' ? 'bg-red-50 text-red-700' : '' }}
                                {{ $purchase->status === 'failed' ? 'bg-gray-50 text-gray-600' : '' }}">
                                {{ $purchase->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $purchase->created_at->format('M d, Y h:i A') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400 font-mono truncate max-w-[120px]">{{ $purchase->stripe_session_id }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">No purchases found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($purchases->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $purchases->links() }}
        </div>
    @endif
</div>
@endsection
