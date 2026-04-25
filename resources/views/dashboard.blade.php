@php
    $title = 'Dashboard';
    $pageTitle = 'Dashboard';
    $activeNav = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <x-card class="lg:col-span-2">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Active Projects</h2>
                    <p class="mt-1 text-sm text-gray-500">Quick overview of what’s moving this week.</p>
                </div>
                <x-button variant="outline" href="{{ url('/projects/acme') }}">View all</x-button>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                @foreach (($projects ?? collect()) as $p)
                    <a href="{{ route('projects.show', $p) }}" class="group rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-500">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="truncate text-sm font-semibold text-gray-900 group-hover:text-blue-700">{{ $p['name'] }}</div>
                                <div class="mt-1 text-xs text-gray-500">{{ $p['domain'] ?? 'General' }}</div>
                            </div>
                            <x-badge status="active">Active</x-badge>
                        </div>
                    </a>
                @endforeach

                @if (($projects ?? collect())->isEmpty())
                    <div class="rounded-xl border border-gray-200 bg-white p-4 text-sm text-gray-500 shadow-sm sm:col-span-2">
                        No projects yet. Complete onboarding to create your first one.
                    </div>
                @endif
            </div>
        </x-card>

        <x-card>
            <h2 class="text-base font-semibold text-gray-900">AI Insights</h2>
            <p class="mt-1 text-sm text-gray-500">Minimal, high-signal suggestions.</p>

            <div class="mt-6 space-y-3">
                <div class="rounded-xl bg-gray-50 p-4">
                    <div class="text-sm font-semibold text-gray-900">Next best action</div>
                    <div class="mt-1 text-sm text-gray-500">Draft a launch checklist for Acme and assign owners.</div>
                </div>
                <div class="rounded-xl bg-gray-50 p-4">
                    <div class="text-sm font-semibold text-gray-900">Risk</div>
                    <div class="mt-1 text-sm text-gray-500">Northstar dependencies are unclear. Add a blocking tasks list.</div>
                </div>
            </div>

            <div class="mt-6">
                @php $firstProject = ($projects ?? collect())->first(); @endphp
                @if ($firstProject)
                    <x-button href="{{ route('projects.show', $firstProject) }}" class="w-full justify-center">Open Project Chat</x-button>
                @else
                    <x-button href="{{ route('onboarding.role') }}" class="w-full justify-center">Start Onboarding</x-button>
                @endif
            </div>
        </x-card>

        <x-card class="lg:col-span-3">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Recent Tasks</h2>
                    <p class="mt-1 text-sm text-gray-500">A clean list with clear states.</p>
                </div>
                <x-button variant="outline" href="{{ route('projects.index') }}">Projects</x-button>
            </div>

            @php $tasks = collect(); @endphp

            <div class="mt-6 divide-y divide-gray-200 rounded-xl border border-gray-200">
                <div class="bg-white px-4 py-3 text-sm text-gray-500">Recent tasks will appear here once you start chatting in a project.</div>
            </div>
        </x-card>
    </div>
@endsection
