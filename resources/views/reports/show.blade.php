@php
    /** @var \App\Models\Report $report */
    /** @var \App\Models\Task $task */
    /** @var \App\Models\Project $project */
@endphp

@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-4 flex items-center justify-end">
            <x-button variant="outline" href="{{ route('projects.show', $project) }}">Back to project</x-button>
            <x-button class="ml-2" href="{{ route('reports.pdf', $report) }}">Download PDF</x-button>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Report</h1>
                    <p class="mt-1 text-sm text-gray-500">Project: {{ $project->name }} · Task: {{ $task->title }}</p>
                </div>
                <x-badge status="active">Generated</x-badge>
            </div>

            <div class="mt-8 space-y-8 text-sm leading-relaxed text-gray-900">
                @if (is_array($report->structured_data) && !empty($report->structured_data))
                    @php
                        $sd = $report->structured_data;
                        $list = fn ($v) => is_array($v) && !empty($v) ? implode("\n", array_map(fn ($x) => "- " . trim((string) $x), $v)) : "—";
                    @endphp

                    <section>
                        <h2 class="text-base font-semibold">Executive Summary</h2>
                        <p class="mt-2 whitespace-pre-wrap text-gray-700">{{ $sd['executive_summary'] ?? '—' }}</p>
                    </section>

                    <section>
                        <h2 class="text-base font-semibold">Problem Analysis</h2>
                        <p class="mt-2 whitespace-pre-wrap text-gray-700">{{ $sd['problem_analysis'] ?? '—' }}</p>
                    </section>

                    <section>
                        <h2 class="text-base font-semibold">Proposed Solution</h2>
                        <p class="mt-2 whitespace-pre-wrap text-gray-700">{{ $sd['proposed_solution'] ?? '—' }}</p>
                    </section>

                    <section>
                        <h2 class="text-base font-semibold">Step-by-Step Execution Plan</h2>
                        <p class="mt-2 whitespace-pre-wrap text-gray-700">{{ $list($sd['execution_plan'] ?? []) }}</p>
                    </section>

                    <section>
                        <h2 class="text-base font-semibold">Tools / Resources</h2>
                        <p class="mt-2 whitespace-pre-wrap text-gray-700">{{ $list($sd['tools_resources'] ?? []) }}</p>
                    </section>

                    <section>
                        <h2 class="text-base font-semibold">Risks & Considerations</h2>
                        <p class="mt-2 whitespace-pre-wrap text-gray-700">{{ $list($sd['risks_considerations'] ?? []) }}</p>
                    </section>

                    <section>
                        <h2 class="text-base font-semibold">Next Actions</h2>
                        <p class="mt-2 whitespace-pre-wrap text-gray-700">{{ $list($sd['next_actions'] ?? []) }}</p>
                    </section>
                @else
                    <section>
                        <h2 class="text-base font-semibold">Executive Summary</h2>
                        <p class="mt-2 text-gray-700">
                            {{ $report->summary ?: '—' }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-base font-semibold">Insights</h2>
                        <p class="mt-2 whitespace-pre-wrap text-gray-700">{{ $report->insights ?: '—' }}</p>
                    </section>

                    <section>
                        <h2 class="text-base font-semibold">Recommendations</h2>
                        <p class="mt-2 whitespace-pre-wrap text-gray-700">{{ $report->recommendations ?: '—' }}</p>
                    </section>
                @endif
            </div>
        </div>
    </div>
@endsection
