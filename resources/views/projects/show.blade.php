@php
    /** @var string $projectId */
    $projectId = $projectId ?? 'acme';
    $title = 'Project';
    $pageTitle = 'Project: ' . strtoupper($projectId);
    $activeNav = 'projects';
    $activeProjectId = $projectId;

    $messages = [
        ['from' => 'ai', 'text' => 'Share your goal for this project and I’ll turn it into tasks, milestones, and a weekly report outline.'],
        ['from' => 'user', 'text' => 'We’re launching a new pricing page. Need a plan for copy, design, and rollout.'],
        ['from' => 'ai', 'text' => 'Got it. I’ll propose a 7-day plan with owners and a checklist. Want a fast or thorough version?'],
    ];

    $steps = [
        ['label' => 'Draft copy variations', 'status' => 'active'],
        ['label' => 'Design review', 'status' => 'pending'],
        ['label' => 'Implement + QA', 'status' => 'pending'],
        ['label' => 'Publish + monitor', 'status' => 'pending'],
    ];
@endphp

@extends('layouts.app')

@section('content')
    <div class="grid h-full grid-cols-1 gap-6 xl:grid-cols-[1fr_350px]">
        <x-card class="flex h-full flex-col p-0">
            <div class="border-b border-gray-200 px-5 py-4 shrink-0">
                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <div class="text-sm font-semibold text-gray-900">Chat</div>
                        <div class="mt-0.5 text-xs text-gray-500">Project workspace conversation</div>
                    </div>
                    <x-button variant="outline" href="{{ url('/reports/weekly') }}">Open report</x-button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto space-y-3 px-5 py-5">
                @foreach ($messages as $m)
                    @if ($m['from'] === 'user')
                        <div class="flex justify-end">
                            <div class="max-w-[75%] rounded-xl bg-blue-600 px-4 py-3 text-sm text-white shadow-sm">
                                {{ $m['text'] }}
                            </div>
                        </div>
                    @else
                        <div class="flex justify-start">
                            <div class="max-w-[75%] rounded-xl bg-gray-100 px-4 py-3 text-sm text-gray-900 shadow-sm">
                                {{ $m['text'] }}
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="border-t border-gray-200 bg-white px-5 py-4 shrink-0">
                <div class="flex items-center gap-3">
                    <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50" aria-label="Upload">
                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true">
                            <path d="M12 16V4m0 0 4 4m-4-4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </button>
                    <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50" aria-label="Voice">
                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true">
                            <path d="M12 14a3 3 0 0 0 3-3V7a3 3 0 1 0-6 0v4a3 3 0 0 0 3 3Z" stroke="currentColor" stroke-width="1.8" />
                            <path d="M19 11a7 7 0 0 1-14 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <path d="M12 18v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </button>

                    <input
                        type="text"
                        placeholder="Message Business Companion AI..."
                        class="h-10 flex-1 rounded-xl border border-gray-200 px-4 text-sm focus:border-blue-500 focus:ring-blue-500"
                    />

                    <x-button>Send</x-button>
                </div>
            </div>
        </x-card>

        <div class="space-y-6">
            <aside class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Task Summary</div>
                        <div class="mt-0.5 text-xs text-gray-500">Auto-generated from chat</div>
                    </div>
                    <x-badge status="active">Active</x-badge>
                </div>

                <div class="mt-5 space-y-3">
                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Status</div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <x-badge status="active">Active</x-badge>
                            <x-badge status="pending">Pending</x-badge>
                            <x-badge status="completed">Completed</x-badge>
                        </div>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Steps</div>
                        <div class="mt-3 space-y-2">
                            @foreach ($steps as $s)
                                <div class="flex items-center justify-between gap-3">
                                    <div class="text-sm text-gray-900">{{ $s['label'] }}</div>
                                    <x-badge status="{{ $s['status'] }}">{{ ucfirst($s['status']) }}</x-badge>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <x-button class="w-full justify-center" href="{{ url('/reports/weekly') }}">Generate Report</x-button>
                </div>
            </aside>

            <aside class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Call Schedule</div>
                        <div class="mt-0.5 text-xs text-gray-500">Dummy upcoming sessions</div>
                    </div>
                    <x-badge status="pending">Optional</x-badge>
                </div>

                @php
                    $calls = [
                        ['day' => 'Mon', 'time' => '10:30 AM', 'title' => 'Kickoff + scope'],
                        ['day' => 'Wed', 'time' => '2:00 PM', 'title' => 'Review copy + tasks'],
                        ['day' => 'Fri', 'time' => '5:15 PM', 'title' => 'Weekly report readout'],
                    ];
                @endphp

                <div class="mt-5 space-y-2">
                    @foreach ($calls as $c)
                        <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white px-3 py-2.5">
                            <div class="min-w-0">
                                <div class="truncate text-sm font-semibold text-gray-900">{{ $c['title'] }}</div>
                                <div class="mt-0.5 text-xs text-gray-500">{{ $c['day'] }} · {{ $c['time'] }}</div>
                            </div>
                            <x-button variant="outline" class="px-3 py-2 text-xs">Details</x-button>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 flex gap-3">
                    <x-button class="flex-1 justify-center">Schedule Call</x-button>
                    <x-button variant="outline" class="flex-1 justify-center">Share Link</x-button>
                </div>
            </aside>
        </div>
    </div>
@endsection
