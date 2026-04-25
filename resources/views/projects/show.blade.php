@php
    /** @var \App\Models\Project $project */
    /** @var \Illuminate\Support\Collection<int,object> $messages */
@endphp

@extends('layouts.app')

@section('content')
    <div class="grid h-full grid-cols-1 gap-6 xl:grid-cols-[1fr_350px]">
        <x-card class="flex h-[calc(100dvh-120px)] min-h-[560px] flex-col p-0">
            <div class="border-b border-gray-200 px-5 py-4 shrink-0">
                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <div class="text-sm font-semibold text-gray-900">Chat</div>
                        <div class="mt-0.5 text-xs text-gray-500">Project workspace conversation</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-button variant="outline" href="{{ route('projects.show', $project) }}">+ New Task</x-button>
                        <div class="text-xs text-gray-500">Project: <span class="font-semibold text-gray-900">{{ $project->name }}</span></div>
                    </div>
                </div>
            </div>

            <div
                id="chat-messages"
                class="flex-1 overflow-y-auto space-y-3 px-5 py-5"
                data-task-url="{{ route('tasks.store') }}"
                data-project-id="{{ $project->id }}"
            >
                @if ($messages->isEmpty())
                    <div class="rounded-xl bg-gray-50 p-4 text-sm text-gray-600">
                        Start a new task. You’ll see live processing steps and a structured response.
                    </div>
                @endif

                @foreach ($messages as $m)
                    @if ($m->role === 'user')
                        <div class="flex justify-end">
                            <div class="max-w-[75%] rounded-xl bg-blue-600 px-4 py-3 text-sm text-white shadow-sm whitespace-pre-wrap">{{ $m->content }}</div>
                        </div>
                    @elseif ($m->role === 'assistant')
                        <div class="flex justify-start">
                            <div class="chat-md max-w-[75%] rounded-xl bg-gray-100 px-4 py-3 text-sm text-gray-900 shadow-sm">{{ $m->content }}</div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="border-t border-gray-200 bg-white px-5 py-4 shrink-0">
                <form id="chat-form" class="flex items-center gap-3">
                    @csrf

                    <input
                        name="message"
                        type="text"
                        placeholder="Message The Business Companion AI..."
                        class="h-10 flex-1 rounded-xl border border-gray-200 px-4 text-sm focus:border-blue-500 focus:ring-blue-500"
                        autocomplete="off"
                        required
                    />

                    <x-button type="submit">Send</x-button>
                </form>
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
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Objective</div>
                        <div class="mt-2 text-sm text-gray-700">{{ $project->objective ?: '—' }}</div>
                    </div>
                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Success metric</div>
                        <div class="mt-2 text-sm text-gray-700">{{ $project->success_metric ?: '—' }}</div>
                    </div>
                </div>
            </aside>

            <aside class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Recent Tasks</div>
                        <div class="mt-0.5 text-xs text-gray-500">Each task is a fresh chat</div>
                    </div>
                </div>

                @php
                    $recentTasks = $project->tasks()
                        ->where('user_id', auth()->id())
                        ->with('report')
                        ->latest('id')
                        ->limit(8)
                        ->get();
                @endphp

                <div class="mt-4 space-y-1">
                    @foreach ($recentTasks as $t)
                        <a href="{{ route('projects.show', $project) }}?task={{ $t->id }}" class="flex items-center justify-between rounded-lg px-2 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <span class="truncate">{{ $t->title }}</span>
                            <span class="text-xs text-gray-500">{{ $t->status }}</span>
                        </a>
                        @if ($t->report)
                            <div class="flex items-center gap-2 px-2 pb-2">
                                <a class="text-xs font-semibold text-blue-600 hover:underline" href="{{ route('reports.show', $t->report) }}">Open report</a>
                                <a class="text-xs font-semibold text-gray-700 hover:underline" href="{{ route('reports.pdf', $t->report) }}">PDF</a>
                            </div>
                        @endif
                    @endforeach
                    @if ($recentTasks->isEmpty())
                        <div class="rounded-lg bg-gray-50 px-3 py-2 text-sm text-gray-500">No tasks yet</div>
                    @endif
                </div>
            </aside>
        </div>
    </div>
@endsection
