@php
    $title = 'Tasks';
    $pageTitle = 'All Tasks';
    $activeNav = 'tasks';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ showNewTask: false, editingTask: null, editTitle: '', editText: '', editMinutes: 30, editPriority: 'medium', editStatus: 'pending', initEdit(task) { this.editingTask = task.id; this.editTitle = task.title; this.editText = task.input_text; this.editMinutes = task.estimated_minutes; this.editPriority = task.priority; this.editStatus = task.status; }, cancelEdit() { this.editingTask = null; } }">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Tasks</h2>
            <p class="text-sm text-gray-500 mt-0.5">Manage all your tasks and track progress.</p>
        </div>
        <div class="flex items-center gap-2">
            @if(session('success'))
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-sm font-medium border border-red-200">
                    <span class="material-symbols-outlined text-[16px]">error</span>
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('tasks.mark-day-completed') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">celebration</span>
                    Mark Day Completed
                </button>
            </form>
            <button @click="showNewTask = true" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">add</span>
                New Task
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">checklist</span>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500">Total Tasks</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">check_circle</span>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                    <p class="text-xs text-gray-500">Completed</p>
                </div>
            </div>
            <div class="mt-2 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 rounded-full" style="width: {{ $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0 }}%"></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">pending</span>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                    <p class="text-xs text-gray-500">Pending</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">today</span>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['today'] }}</p>
                    <p class="text-xs text-gray-500">Today's Tasks</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Current Day Tasks --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <h3 class="font-semibold text-gray-900">Today's Tasks</h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ $today }}</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-medium text-gray-500">
                <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> High</span>
                <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Med</span>
                <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Low</span>
            </div>
        </div>
        <div class="p-1">
            @forelse ($currentTasks as $task)
                @php $pc = $priorityColors[$task->priority] ?? $priorityColors['medium']; @endphp
                {{-- Inline Edit Form --}}
                <div x-show="editingTask === {{ $task->id }}" x-cloak class="px-4 py-3 mx-1 border-b border-gray-50 bg-blue-50/30 rounded-lg">
                    <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Title</label>
                                <input type="text" name="title" x-model="editTitle" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Est. Minutes</label>
                                <input type="number" name="estimated_minutes" x-model="editMinutes" min="1" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Details</label>
                            <textarea name="input_text" x-model="editText" rows="2" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm"></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Priority</label>
                                <select name="priority" x-model="editPriority" class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" x-model="editStatus" class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="discarded">Discarded</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <button type="button" @click="cancelEdit()" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-700 hover:bg-gray-50 transition-all">
                                Cancel
                            </button>
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-primary text-white text-xs font-semibold hover:bg-primary-container transition-all shadow-sm">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                {{-- Task Row --}}
                <div x-show="editingTask !== {{ $task->id }}" class="flex items-start gap-3 px-4 py-3 rounded-lg mx-1 {{ $task->status === 'discarded' ? 'opacity-50' : 'hover:bg-gray-50' }} transition-colors {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                    <div class="mt-0.5">
                        @if($task->status !== 'discarded')
                        <form action="{{ route('tasks.complete', $task) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-5 h-5 rounded border {{ $task->status === 'completed' ? 'bg-primary border-primary text-white' : 'border-gray-300 bg-white hover:border-primary' }} flex items-center justify-center transition-colors">
                                @if($task->status === 'completed')
                                    <span class="material-symbols-outlined text-[14px] font-bold">check</span>
                                @endif
                            </button>
                        </form>
                        @else
                        <div class="w-5 h-5 rounded border border-gray-200 bg-gray-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[12px] text-gray-400">close</span>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="text-sm font-medium text-gray-900 {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }} {{ $task->status === 'discarded' ? 'text-gray-400 line-through' : '' }}">{{ $task->title }}</h4>
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-medium {{ $pc['bg'] }} {{ $pc['text'] }}">
                                <span class="w-1 h-1 rounded-full {{ $pc['dot'] }}"></span>
                                {{ ucfirst($task->priority) }}
                            </span>
                            @if($task->status === 'discarded')
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-500">Discarded</span>
                            @endif
                            @if($task->status === 'completed')
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-700">Completed</span>
                            @endif
                        </div>
                        @if($task->input_text)
                            <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $task->input_text }}</p>
                        @endif
                        <div class="flex items-center gap-3 mt-1.5">
                            @if($task->estimated_minutes)
                            <span class="inline-flex items-center gap-0.5 text-[11px] font-medium text-gray-400">
                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                {{ $task->estimated_minutes }} min
                            </span>
                            @endif
                            @if($task->scheduled_followup_time)
                            <span class="inline-flex items-center gap-0.5 text-[11px] font-medium text-gray-400">
                                <span class="material-symbols-outlined text-[14px]">notifications</span>
                                {{ \Carbon\Carbon::parse($task->scheduled_followup_time)->format('h:i A') }}
                            </span>
                            @endif
                            <button @click="initEdit({ id: {{ $task->id }}, title: '{{ addslashes($task->title) }}', input_text: '{{ addslashes($task->input_text) }}', estimated_minutes: {{ $task->estimated_minutes ?? 30 }}, priority: '{{ $task->priority }}', status: '{{ $task->status }}' })" class="text-[11px] font-medium text-gray-400 hover:text-primary transition-colors">Edit</button>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[11px] font-medium text-gray-400 hover:text-red-500 transition-colors">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">checklist</span>
                    <p class="text-sm text-gray-500 font-medium">No tasks for today.</p>
                    <p class="text-xs text-gray-400 mt-1">Create a new task to get started.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Previous Tasks --}}
    @if($previousTasks->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Previous Tasks</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach ($previousTasks as $task)
                @php $pc = $priorityColors[$task->priority] ?? $priorityColors['medium']; @endphp
                {{-- Inline Edit Form --}}
                <div x-show="editingTask === {{ $task->id }}" x-cloak class="px-5 py-3 bg-blue-50/30">
                    <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Title</label>
                                <input type="text" name="title" x-model="editTitle" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Est. Minutes</label>
                                <input type="number" name="estimated_minutes" x-model="editMinutes" min="1" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Details</label>
                            <textarea name="input_text" x-model="editText" rows="2" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm"></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Priority</label>
                                <select name="priority" x-model="editPriority" class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" x-model="editStatus" class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="discarded">Discarded</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <button type="button" @click="cancelEdit()" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-700 hover:bg-gray-50 transition-all">
                                Cancel
                            </button>
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-primary text-white text-xs font-semibold hover:bg-primary-container transition-all shadow-sm">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                {{-- Task Row --}}
                <div x-show="editingTask !== {{ $task->id }}" class="flex items-start gap-3 px-5 py-3 {{ $task->status === 'discarded' ? 'opacity-50' : 'hover:bg-gray-50' }} transition-colors">
                    <div class="mt-0.5">
                        <form action="{{ route('tasks.complete', $task) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-5 h-5 rounded border {{ $task->status === 'completed' ? 'bg-primary border-primary text-white' : 'border-gray-300 bg-white hover:border-primary' }} flex items-center justify-center transition-colors">
                                @if($task->status === 'completed')
                                    <span class="material-symbols-outlined text-[14px] font-bold">check</span>
                                @endif
                            </button>
                        </form>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="text-sm font-medium text-gray-900 {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }}">{{ $task->title }}</h4>
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-medium {{ $pc['bg'] }} {{ $pc['text'] }}">
                                <span class="w-1 h-1 rounded-full {{ $pc['dot'] }}"></span>
                                {{ ucfirst($task->priority) }}
                            </span>
                            @if($task->status === 'completed')
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-700">Completed</span>
                            @endif
                            @if($task->status === 'discarded')
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-500">Discarded</span>
                            @endif
                        </div>
                        @if($task->input_text)
                            <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $task->input_text }}</p>
                        @endif
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-[11px] text-gray-400">{{ \Carbon\Carbon::parse($task->date)->format('M d, Y') }}</span>
                            @if($task->estimated_minutes)
                            <span class="inline-flex items-center gap-0.5 text-[11px] text-gray-400">
                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                {{ $task->estimated_minutes }} min
                            </span>
                            @endif
                            @if($task->scheduled_followup_time)
                            <span class="inline-flex items-center gap-0.5 text-[11px] text-gray-400">
                                <span class="material-symbols-outlined text-[14px]">notifications</span>
                                {{ \Carbon\Carbon::parse($task->scheduled_followup_time)->format('h:i A') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="initEdit({ id: {{ $task->id }}, title: '{{ addslashes($task->title) }}', input_text: '{{ addslashes($task->input_text) }}', estimated_minutes: {{ $task->estimated_minutes ?? 30 }}, priority: '{{ $task->priority }}', status: '{{ $task->status }}' })" class="text-[11px] font-medium text-gray-400 hover:text-primary transition-colors">Edit</button>
                        <span class="text-[10px] font-medium {{ $task->status === 'completed' ? 'text-green-600' : 'text-gray-400' }}">
                            {{ ucfirst($task->status) }}
                        </span>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Delete this task?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-gray-300 hover:text-red-500 transition-colors">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        @if($previousTasks->hasPages())
        <div class="px-5 py-3 border-t border-gray-100">
            {{ $previousTasks->links() }}
        </div>
        @endif
    </div>
    @endif

    {{-- New Task Modal --}}
    <div x-show="showNewTask" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/20 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full relative border border-gray-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">New Task</h3>
                <button @click="showNewTask = false" class="text-gray-400 hover:text-gray-600 p-1 rounded hover:bg-gray-100 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <form action="{{ route('tasks.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Details</label>
                    <textarea name="input_text" rows="3" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Est. Minutes</label>
                        <input type="number" name="estimated_minutes" value="30" min="1" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                        <select name="priority" class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" @click="showNewTask = false" class="flex-1 px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                        Save Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection