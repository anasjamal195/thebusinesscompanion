@extends('admin.layouts.app', ['title' => 'Edit User — ' . $user->name, 'activeNav' => 'users', 'pageTitle' => 'Edit User'])

@section('content')
<form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf
    @method('PUT')

    @if (session('success'))
        <div class="mb-5 flex items-center gap-2.5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-sm font-bold text-gray-900">User Details</h2>
            <p class="mt-0.5 text-xs text-gray-400">Update the user's account details and credits.</p>
        </div>

        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="text-sm font-medium text-gray-900">Name <span class="text-red-500">*</span></label>
                    <input name="name" value="{{ old('name', $user->name) }}" required
                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary" />
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Email <span class="text-red-500">*</span></label>
                    <input name="email" type="email" value="{{ old('email', $user->email) }}" required
                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary" />
                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Role <span class="text-red-500">*</span></label>
                    <select name="role" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary">
                        @foreach (['user', 'admin'] as $role)
                            <option value="{{ $role }}" {{ old('role', $user->role ?? 'user') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                    @error('role') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Credits <span class="text-red-500">*</span></label>
                    <input name="credits" type="number" step="0.01" min="0" value="{{ old('credits', $user->credits) }}" required
                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary" />
                    <p class="mt-1 text-xs text-gray-400">Set to the user's new balance. Credits are the currency used for calls.</p>
                    @error('credits') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center gap-3">
        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary/90 transition-all">
            <span class="material-symbols-outlined text-[18px]">save</span>
            Save Changes
        </button>
        <a href="{{ route('admin.users.show', $user) }}" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-gray-500 hover:bg-gray-100 transition-colors">Cancel</a>
    </div>
</form>
@endsection
