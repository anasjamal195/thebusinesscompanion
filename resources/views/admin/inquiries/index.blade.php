@extends('admin.layouts.app', ['title' => 'Inquiries', 'activeNav' => 'inquiries', 'pageTitle' => 'Inquiries'])

@section('content')
<div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Name</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Email</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Phone</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Service</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Message</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Date</th>
                    <th class="text-right text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($inquiries as $inquiry)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4">
                            <span class="text-sm font-semibold text-gray-900">{{ $inquiry->name }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <a href="mailto:{{ $inquiry->email }}" class="text-sm text-primary hover:underline">{{ $inquiry->email }}</a>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $inquiry->phone ?? '—' }}</td>
                        <td class="px-5 py-4">
                            @if($inquiry->service)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-primary/10 text-primary">{{ $inquiry->service }}</span>
                            @else
                                <span class="text-sm text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $inquiry->message }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $inquiry->created_at->format('M d, Y h:i A') }}</td>
                        <td class="px-5 py-4 text-right">
                            <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" class="inline"
                                onsubmit="return confirm('Delete this inquiry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold text-red-500 hover:text-red-700 transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-sm text-gray-500">No inquiries yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($inquiries->hasPages())
        <div class="px-5 py-4 border-t border-gray-200">
            {{ $inquiries->links() }}
        </div>
    @endif
</div>
@endsection
