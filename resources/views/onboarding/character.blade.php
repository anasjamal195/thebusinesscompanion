@php
    $title = 'Finish Setup';
    $pageTitle = 'Create First Project + Task';
    $activeNav = 'dashboard';

    $role = auth()->user()->role;
    $characters = \App\Models\AiCharacter::query()
        ->where('occupation', $role)
        ->orderBy('id')
        ->limit(9)
        ->get();
@endphp

@extends('layouts.app')

@section('content')
    <x-card>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Create your first project and task</h2>
                <p class="mt-1 text-sm text-gray-500">Once you submit, the first task will be processed by the queue.</p>
            </div>
            <x-badge status="active">Setup</x-badge>
        </div>

        @php
            $selected = old('character_type', auth()->user()->character_type ?: ($characters->first()->key ?? ''));
        @endphp

        <form method="POST" action="{{ route('onboarding.complete') }}" class="mt-6 space-y-6">
            @csrf

            <div>
                <div class="text-sm font-semibold text-gray-900">Character (optional)</div>
                <div class="mt-1 text-sm text-gray-500">Role: <span class="font-semibold text-gray-900">{{ $role ?: '—' }}</span></div>

                <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($characters as $c)
                        <label class="block cursor-pointer">
                            <input type="radio" name="character_type" value="{{ $c->key }}" class="peer sr-only" {{ $c->key === $selected ? 'checked' : '' }} />
                            <div class="rounded-xl border border-gray-200 bg-white p-4 text-left shadow-sm transition hover:border-blue-400 peer-checked:border-blue-600 peer-checked:bg-blue-50">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 overflow-hidden rounded-full bg-gray-100 ring-1 ring-gray-200">
                                        @if ($c->avatar_url)
                                            <img src="{{ $c->avatar_url }}" alt="{{ $c->name }}" class="h-full w-full object-cover" />
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="truncate text-sm font-semibold text-gray-900">{{ $c->name }}</div>
                                        <div class="truncate text-xs text-gray-500">{{ $c->tagline }}</div>
                                    </div>
                                </div>

                                <div class="mt-3 text-xs text-gray-500">{{ $c->bio }}</div>

                                <div class="mt-3 hidden rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white peer-checked:block">
                                    Selected
                                </div>
                            </div>
                        </label>
                    @empty
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-600 sm:col-span-2 lg:col-span-3">
                            No characters found for your role yet. Run `php artisan app:generate-ai-characters`.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">Project name</label>
                    <input name="project_name" value="{{ old('project_name') }}" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Acme Launch" required />
                    @error('project_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">Project description</label>
                    <textarea name="project_description" rows="3" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="What is this project about?">{{ old('project_description') }}</textarea>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Domain</label>
                    <input name="domain" value="{{ old('domain') }}" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="marketing, development, trading..." />
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Success metric</label>
                    <input name="success_metric" value="{{ old('success_metric') }}" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. +20% conversion" />
                </div>

                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">Objective</label>
                    <textarea name="objective" rows="3" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="What’s the outcome?">{{ old('objective') }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">First task title</label>
                    <input name="task_title" value="{{ old('task_title') }}" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Create a 7-day plan..." required />
                    @error('task_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">Task description</label>
                    <textarea name="task_description" rows="5" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Describe what you want the AI to do..." required>{{ old('task_description') }}</textarea>
                    @error('task_description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Priority</label>
                    @php $prio = old('priority', 'medium'); @endphp
                    <select name="priority" class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="low" {{ $prio === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $prio === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $prio === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center justify-between gap-3">
                <x-button variant="outline" href="{{ route('onboarding.business') }}">Back</x-button>
                <x-button type="submit">Create + Run First Task</x-button>
            </div>
        </form>
    </x-card>
@endsection
