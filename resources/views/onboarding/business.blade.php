@php
    $title = 'Business Info';
    $pageTitle = 'Business Info';
    $activeNav = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <x-card>
            <div>
                <h2 class="text-base font-semibold text-gray-900">Tell us about your business</h2>
                <p class="mt-1 text-sm text-gray-500">Dummy fields only. Focus is UI structure and style.</p>
            </div>

            <form class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">Business name</label>
                    <input class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Acme Inc." />
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Industry</label>
                    <input class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="SaaS" />
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Website</label>
                    <input class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://example.com" />
                </div>

                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">What are you trying to achieve?</label>
                    <textarea rows="5" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Describe goals, constraints, and timeline..."></textarea>
                </div>

                <div class="sm:col-span-2 mt-2 flex items-center justify-between gap-3">
                    <x-button variant="outline" href="{{ url('/onboarding/call') }}">Back</x-button>
                    <x-button href="{{ url('/onboarding/character') }}">Continue</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection

