@php
    $title = 'Select Role';
    $pageTitle = 'Role Selection';
    $activeNav = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
    <x-card>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Pick a role to personalize your workspace</h2>
                <p class="mt-1 text-sm text-gray-500">This helps shape prompts, reporting, and task templates.</p>
            </div>
            <x-badge status="active">Onboarding</x-badge>
        </div>

        @php
            $roles = ['Founder', 'Engineer', 'Marketer', 'Researcher', 'Creator', 'Musician', 'Parent', 'Trader'];
            $selected = old('role', auth()->user()->role ?: 'Founder');
        @endphp

        <form method="POST" action="{{ route('onboarding.role.save') }}">
            @csrf

            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($roles as $role)
                    @php $isSelected = $role === $selected; @endphp
                    <label class="block cursor-pointer">
                        <input type="radio" name="role" value="{{ $role }}" class="peer sr-only" {{ $isSelected ? 'checked' : '' }} />
                        <div class="rounded-xl border border-gray-200 bg-white p-4 text-left shadow-sm transition hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50">
                            <div class="text-sm font-semibold text-gray-900">{{ $role }}</div>
                            <div class="mt-1 text-xs text-gray-500">Recommended flows and templates</div>
                        </div>
                    </label>
                @endforeach
            </div>

            @error('role')
                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="mt-8 flex justify-end">
                <x-button type="submit">Continue</x-button>
            </div>
        </form>
    </x-card>
@endsection
