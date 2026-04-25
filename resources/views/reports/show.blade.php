@php
    /** @var string $reportId */
    $reportId = $reportId ?? 'weekly';
    $title = 'Report';
    $pageTitle = 'Report';
    $activeNav = 'reports';
@endphp

@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-4 flex items-center justify-end">
            <x-button href="#" class="">Download PDF</x-button>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Weekly Report</h1>
                    <p class="mt-1 text-sm text-gray-500">Report ID: {{ $reportId }} · Dummy content</p>
                </div>
                <x-badge status="active">Generated</x-badge>
            </div>

            <div class="mt-8 space-y-8 text-sm leading-relaxed text-gray-900">
                <section>
                    <h2 class="text-base font-semibold">Executive Summary</h2>
                    <p class="mt-2 text-gray-700">
                        This week focused on clarifying scope, drafting copy variations, and aligning on rollout steps.
                    </p>
                </section>

                <section>
                    <h2 class="text-base font-semibold">Progress</h2>
                    <ul class="mt-2 list-disc space-y-1 pl-5 text-gray-700">
                        <li>Defined success metrics and tracking</li>
                        <li>Collected stakeholder feedback</li>
                        <li>Prepared a QA checklist</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-base font-semibold">Risks</h2>
                    <p class="mt-2 text-gray-700">
                        Dependencies and approvals may delay the rollout. Add owners and deadlines for each blocker.
                    </p>
                </section>

                <section>
                    <h2 class="text-base font-semibold">Next Steps</h2>
                    <ol class="mt-2 list-decimal space-y-1 pl-5 text-gray-700">
                        <li>Finalize copy</li>
                        <li>Design review</li>
                        <li>Implement + QA</li>
                        <li>Publish + monitor</li>
                    </ol>
                </section>
            </div>
        </div>
    </div>
@endsection
