@extends('admin.layouts.app', ['title' => 'User Management', 'activeNav' => 'users', 'pageTitle' => 'User Management'])

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">User</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="text-center px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Calls</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Credits</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Joined</th>
                    <th class="text-right px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700' : 'bg-gray-50 text-gray-600' }}">
                                {{ $user->role ?? 'user' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm font-semibold text-gray-900">{{ $user->calls_count }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ number_format($user->credits, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-primary hover:text-primary-container transition-colors">
                                View
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
