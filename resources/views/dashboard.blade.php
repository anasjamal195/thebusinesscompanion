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
                @php
                    $projects = [
                        ['id' => 'acme', 'name' => 'Acme Launch', 'status' => 'active', 'progress' => '72%'],
                        ['id' => 'northstar', 'name' => 'Northstar Revamp', 'status' => 'pending', 'progress' => '34%'],
                        ['id' => 'atlas', 'name' => 'Atlas Research', 'status' => 'active', 'progress' => '58%'],
                        ['id' => 'studio', 'name' => 'Studio Ops', 'status' => 'completed', 'progress' => '100%'],
                    ];
                @endphp

                @foreach ($projects as $p)
                    <a href="{{ url('/projects/' . $p['id']) }}" class="group rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-500">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="truncate text-sm font-semibold text-gray-900 group-hover:text-blue-700">{{ $p['name'] }}</div>
                                <div class="mt-1 text-xs text-gray-500">Progress: {{ $p['progress'] }}</div>
                            </div>
                            <x-badge status="{{ $p['status'] }}">{{ ucfirst($p['status']) }}</x-badge>
                        </div>
                    </a>
                @endforeach
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
                <x-button href="{{ url('/projects/acme') }}" class="w-full justify-center">Open Project Chat</x-button>
            </div>
        </x-card>

        <x-card class="lg:col-span-3">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Recent Tasks</h2>
                    <p class="mt-1 text-sm text-gray-500">A clean list with clear states.</p>
                </div>
                <x-button variant="outline" href="{{ url('/reports/weekly') }}">Open report</x-button>
            </div>

            @php
                $tasks = [
                    ['title' => 'Define success metrics', 'status' => 'active', 'project' => 'Acme Launch'],
                    ['title' => 'Collect user feedback notes', 'status' => 'pending', 'project' => 'Atlas Research'],
                    ['title' => 'Finalize rollout plan', 'status' => 'active', 'project' => 'Northstar Revamp'],
                    ['title' => 'Publish weekly report', 'status' => 'completed', 'project' => 'Studio Ops'],
                ];
            @endphp

            <div class="mt-6 divide-y divide-gray-200 rounded-xl border border-gray-200">
                @foreach ($tasks as $t)
                    <div class="flex items-center justify-between gap-4 bg-white px-4 py-3">
                        <div class="min-w-0">
                            <div class="truncate text-sm font-semibold text-gray-900">{{ $t['title'] }}</div>
                            <div class="mt-0.5 text-xs text-gray-500">{{ $t['project'] }}</div>
                        </div>
                        <x-badge status="{{ $t['status'] }}">{{ ucfirst($t['status']) }}</x-badge>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>
@endsection

