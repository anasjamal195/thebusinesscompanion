@extends('admin.layouts.app', ['title' => 'Waitlist', 'activeNav' => 'waitlist', 'pageTitle' => 'Waitlist'])

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date Joined</th>
                    <th class="text-right px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($entries as $entry)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[22px]">mail</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $entry->email }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $entry->created_at->format('M d, Y h:i A') }}</td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="{{ route('admin.waitlist.destroy', $entry) }}" class="inline"
                                onsubmit="return confirm('Remove this entry from the waitlist?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-bold text-red-500 hover:text-red-700 transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-500">No waitlist entries.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($entries->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $entries->links() }}
        </div>
    @endif
</div>
@endsection
