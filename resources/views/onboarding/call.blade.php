@php
    $title = 'Call Option';
    $pageTitle = 'Call Option';
    $activeNav = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-card class="border-blue-200 bg-blue-50">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Start with a guided call</h2>
                    <p class="mt-1 text-sm text-gray-500">
                        We’ll ask a few questions and generate a plan, tasks, and a report outline.
                    </p>
                </div>
                <x-badge status="active">Recommended</x-badge>
            </div>

            <div class="mt-6 space-y-2 text-sm text-gray-700">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                    <span>Faster onboarding</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                    <span>Better first report quality</span>
                </div>
            </div>

            <div class="mt-8">
                <x-button href="{{ url('/onboarding/business') }}">Start call</x-button>
            </div>
        </x-card>

        <x-card>
            <h2 class="text-base font-semibold text-gray-900">Skip the call</h2>
            <p class="mt-1 text-sm text-gray-500">Jump straight into your workspace and fill details later.</p>

            <div class="mt-8">
                <x-button variant="outline" href="{{ url('/onboarding/business') }}">Continue without call</x-button>
            </div>
        </x-card>
    </div>
@endsection

