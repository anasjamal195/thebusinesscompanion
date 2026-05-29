@php
    $title = 'Reports';
    $pageTitle = 'Daily Reports';
    $activeNav = 'reports';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Reports</h2>
            <p class="text-sm text-gray-500 font-medium mt-1">Daily progress reports and task summaries.</p>
        </div>
        <div class="flex gap-2 text-sm font-bold text-gray-500 bg-white rounded-2xl px-4 py-2 border border-gray-100 shadow-sm">
            <span class="text-green-600">{{ count($allReports) }}</span> reports
        </div>
    </div>

    @forelse ($allReports as $entry)
        @php
            $isDaily = $entry['type'] === 'daily';
            $badgeClass = $isDaily ? 'bg-purple-100 text-purple-700' : 'bg-primary/10 text-primary';
            $badgeLabel = $isDaily ? 'Daily Summary' : 'Task Report';
        @endphp
        <a href="{{ $entry['route'] }}" class="block bg-white rounded-[2.5rem] p-6 shadow-lg shadow-gray-200/30 border border-gray-50 hover:border-primary/20 hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-start justify-between gap-6">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 {{ $badgeClass }} rounded-full text-[10px] font-black uppercase tracking-wider">{{ $badgeLabel }}</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-[10px] font-black uppercase tracking-wider">{{ $entry['title'] }}</span>
                    </div>
                    <p class="text-gray-700 text-sm mt-2 line-clamp-2">{{ $entry['summary'] ? Str::limit($entry['summary'], 200) : 'No summary available.' }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-xs font-bold text-gray-400">{{ $entry['date']?->format('M j, Y g:i A') ?? 'N/A' }}</p>
                    <span class="material-symbols-outlined text-gray-300 group-hover:text-primary transition-colors mt-1">chevron_right</span>
                </div>
            </div>
        </a>
    @empty
        <div class="bg-white rounded-[2.5rem] p-12 shadow-lg shadow-gray-200/30 border border-gray-50 text-center">
            <span class="material-symbols-outlined text-5xl text-gray-300 mb-4">summarize</span>
            <p class="text-gray-500 font-medium">No reports yet. Complete tasks to generate reports.</p>
        </div>
    @endforelse
</div>
@endsection