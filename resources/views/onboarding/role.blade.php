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
            $selected = 'Founder';
        @endphp

        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($roles as $role)
                @php
                    $isSelected = $role === $selected;
                @endphp
                <button
                    type="button"
                    class="{{ $isSelected ? 'border-blue-600 bg-blue-50' : 'border-gray-200 bg-white hover:border-blue-500' }} w-full rounded-xl border p-4 text-left shadow-sm transition"
                >
                    <div class="text-sm font-semibold text-gray-900">{{ $role }}</div>
                    <div class="mt-1 text-xs text-gray-500">Recommended flows and templates</div>
                </button>
            @endforeach
        </div>

        <div class="mt-8 flex justify-end">
            <x-button href="{{ url('/onboarding/call') }}">Continue</x-button>
        </div>
    </x-card>
@endsection
