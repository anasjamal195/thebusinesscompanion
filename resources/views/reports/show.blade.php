@php
    /** @var \App\Models\Report $report */
    /** @var \App\Models\Task $task */
    /** @var \App\Models\Project $project */
    $title = 'Report';
    $pageTitle = 'Report';
    $activeNav = 'reports';
@endphp

@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-400 hover:text-gray-600 transition-colors">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Back to Reports
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('reports.pdf', $report) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">download</span>
                    PDF
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-lg font-bold text-gray-900">Task Report</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Project: {{ $project->name }} &middot; Task: {{ $task->title }}</p>
                </div>
                <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium bg-blue-50 text-blue-700 ring-1 ring-blue-200">Generated</span>
            </div>

            <div class="mt-6 space-y-6 text-sm leading-relaxed text-gray-900">
                @if (is_array($report->structured_data) && !empty($report->structured_data))
                    @php
                        $sd = $report->structured_data;
                        $list = fn ($v) => is_array($v) && !empty($v) ? implode('<br>', array_map(fn ($x) => "• " . e(trim((string) $x)), $v)) : "—";
                    @endphp

                    <section>
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Executive Summary</h2>
                        <p class="text-gray-600 whitespace-pre-wrap">{{ $sd['executive_summary'] ?? '—' }}</p>
                    </section>

                    <section>
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Problem Analysis</h2>
                        <p class="text-gray-600 whitespace-pre-wrap">{{ $sd['problem_analysis'] ?? '—' }}</p>
                    </section>

                    <section>
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Proposed Solution</h2>
                        <p class="text-gray-600 whitespace-pre-wrap">{{ $sd['proposed_solution'] ?? '—' }}</p>
                    </section>

                    <section>
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Execution Plan</h2>
                        <p class="text-gray-600 whitespace-pre-wrap">{!! $list($sd['execution_plan'] ?? []) !!}</p>
                    </section>

                    <section>
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Tools & Resources</h2>
                        <p class="text-gray-600 whitespace-pre-wrap">{!! $list($sd['tools_resources'] ?? []) !!}</p>
                    </section>

                    <section>
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Risks & Considerations</h2>
                        <p class="text-gray-600 whitespace-pre-wrap">{!! $list($sd['risks_considerations'] ?? []) !!}</p>
                    </section>

                    <section>
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Next Actions</h2>
                        <p class="text-gray-600 whitespace-pre-wrap">{!! $list($sd['next_actions'] ?? []) !!}</p>
                    </section>
                @else
                    <section>
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Executive Summary</h2>
                        <p class="text-gray-600">{{ $report->summary ?: '—' }}</p>
                    </section>

                    <section>
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Insights</h2>
                        <p class="text-gray-600 whitespace-pre-wrap">{{ $report->insights ?: '—' }}</p>
                    </section>

                    <section>
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Recommendations</h2>
                        <p class="text-gray-600 whitespace-pre-wrap">{{ $report->recommendations ?: '—' }}</p>
                    </section>
                @endif
            </div>
        </div>
    </div>
@endsection
