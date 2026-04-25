@php
    $title = 'Welcome';
    $pageTitle = 'Welcome';
    $activeNav = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-card class="flex flex-col justify-between">
            <div>
                <div class="text-sm font-semibold text-blue-600">Business Companion AI</div>
                <h2 class="mt-2 text-2xl font-semibold text-gray-900">Premium, minimal SaaS wireframe</h2>
                <p class="mt-2 text-sm text-gray-500">
                    This is a UI-only skeleton: onboarding, dashboard, projects chat view, and report view.
                </p>
            </div>
            <div class="mt-6 flex flex-wrap gap-3">
                <x-button href="{{ url('/login') }}">Go to login</x-button>
                <x-button variant="outline" href="{{ url('/dashboard') }}">Open dashboard</x-button>
            </div>
        </x-card>

        <x-card>
            <h3 class="text-base font-semibold text-gray-900">Quick Links</h3>
            <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <a class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-500" href="{{ url('/onboarding/role') }}">
                    <div class="text-sm font-semibold text-gray-900">Role selection</div>
                    <div class="mt-1 text-sm text-gray-500">/onboarding/role</div>
                </a>
                <a class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-500" href="{{ url('/onboarding/call') }}">
                    <div class="text-sm font-semibold text-gray-900">Call option</div>
                    <div class="mt-1 text-sm text-gray-500">/onboarding/call</div>
                </a>
                <a class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-500" href="{{ url('/onboarding/business') }}">
                    <div class="text-sm font-semibold text-gray-900">Business info</div>
                    <div class="mt-1 text-sm text-gray-500">/onboarding/business</div>
                </a>
                <a class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-500" href="{{ url('/onboarding/character') }}">
                    <div class="text-sm font-semibold text-gray-900">Character selection</div>
                    <div class="mt-1 text-sm text-gray-500">/onboarding/character</div>
                </a>
            </div>
        </x-card>
    </div>
@endsection

