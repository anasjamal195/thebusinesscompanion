@php
    $title = 'Reports';
    $pageTitle = 'Reports';
    $activeNav = 'reports';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Reports</h2>
            <p class="text-sm text-gray-500 mt-0.5">Daily progress reports and task summaries.</p>
        </div>
        <div class="text-sm font-medium text-gray-500 bg-white rounded-lg px-3 py-1.5 border border-gray-200 shadow-sm">
            <span class="text-green-600">{{ count($allReports) }}</span> reports
        </div>
    </div>

    <div class="space-y-3">
        @forelse ($allReports as $entry)
            @php
                $isDaily = $entry['type'] === 'daily';
                $badgeClass = $isDaily ? 'bg-purple-50 text-purple-700' : 'bg-primary/10 text-primary';
                $badgeLabel = $isDaily ? 'Daily Summary' : 'Task Report';
            @endphp
            <a href="{{ $entry['route'] }}" class="block bg-white rounded-xl border border-gray-200 shadow-sm p-4 hover:border-gray-300 hover:shadow-md transition-all duration-200 group">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="px-2 py-0.5 {{ $badgeClass }} rounded-md text-[10px] font-semibold">{{ $badgeLabel }}</span>
                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-md text-[10px] font-semibold">{{ $entry['title'] }}</span>
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ $entry['summary'] ? \Illuminate\Support\Str::limit($entry['summary'], 200) : 'No summary available.' }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-xs text-gray-400 font-medium">{{ $entry['date']?->format('M j, Y g:i A') ?? 'N/A' }}</p>
                        <span class="material-symbols-outlined text-gray-300 group-hover:text-primary transition-colors mt-0.5 text-[20px]">chevron_right</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm text-center py-12">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">summarize</span>
                <p class="text-sm text-gray-500">No reports yet. Complete tasks to generate reports.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
