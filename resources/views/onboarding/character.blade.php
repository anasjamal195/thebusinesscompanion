@php
    $title = 'Select Character';
    $pageTitle = 'Character Selection';
    $activeNav = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
    <x-card>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Choose your AI companion</h2>
                <p class="mt-1 text-sm text-gray-500">Pick a tone and working style (dummy data).</p>
            </div>
            <x-badge status="active">Setup</x-badge>
        </div>

        @php
            $characters = [
                ['id' => 'alex', 'name' => 'Alex', 'desc' => 'Direct, structured, execution-focused'],
                ['id' => 'maya', 'name' => 'Maya', 'desc' => 'Warm, creative, idea-to-plan'],
                ['id' => 'rio', 'name' => 'Rio', 'desc' => 'Fast brainstorms, marketing angles'],
                ['id' => 'sage', 'name' => 'Sage', 'desc' => 'Research-heavy, careful reasoning'],
                ['id' => 'noah', 'name' => 'Noah', 'desc' => 'Product thinking, prioritization'],
                ['id' => 'jules', 'name' => 'Jules', 'desc' => 'Ops and systems, clean checklists'],
            ];
            $selected = 'alex';
        @endphp

        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($characters as $c)
                @php $isSelected = $c['id'] === $selected; @endphp
                <button
                    type="button"
                    class="{{ $isSelected ? 'border-blue-600 bg-blue-50' : 'border-gray-200 bg-white hover:border-blue-400' }} rounded-xl border p-4 text-center shadow-sm transition"
                >
                    <div class="mx-auto h-12 w-12 rounded-full bg-gray-100 ring-1 ring-gray-200"></div>
                    <div class="mt-3 text-sm font-semibold text-gray-900">{{ $c['name'] }}</div>
                    <div class="mt-1 text-xs text-gray-500">{{ $c['desc'] }}</div>
                </button>
            @endforeach
        </div>

        <div class="mt-8 flex items-center justify-between gap-3">
            <x-button variant="outline" href="{{ url('/onboarding/business') }}">Back</x-button>
            <x-button href="{{ url('/dashboard') }}">Finish</x-button>
        </div>
    </x-card>
@endsection

