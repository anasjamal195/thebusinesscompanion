@extends('admin.layouts.app', ['title' => 'User Management', 'activeNav' => 'users', 'pageTitle' => 'User Management'])

@section('content')
<div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">User</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Email</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Role</th>
                    <th class="text-center text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Calls</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Credits</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Joined</th>
                    <th class="text-right text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700' : 'bg-gray-50 text-gray-600' }}">
                                {{ $user->role ?? 'user' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center text-sm font-semibold text-gray-900">{{ $user->calls_count }}</td>
                        <td class="px-5 py-4 text-sm text-gray-600">{{ number_format($user->credits, 2) }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.users.edit', $user) }}" title="Edit {{ $user->name }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                    Edit
                                </a>
                                <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:text-primary-container transition-colors">
                                    View
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-sm text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="px-5 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
