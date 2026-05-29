@php
    $title = 'Dashboard';
    $pageTitle = 'Today\'s Tasks';
    $activeNav = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Welcome Header -->
    <div class="relative overflow-hidden bg-white rounded-[3rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100 group">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors duration-700"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-black uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                    <span>Scheduled for {{ auth()->user()->morning_call_time }}</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight">
                    Hello, <span class="text-primary">{{ explode(' ', auth()->user()->name)[0] }}</span>.
                </h2>
                <p class="text-lg text-gray-500 max-w-xl font-medium">
                    You have <span class="text-gray-900 font-bold">{{ $tasks->where('status', 'pending')->count() }}</span> pending tasks for today.
                </p>
            </div>
            <div class="flex gap-4">
                <button onclick="document.getElementById('newTaskModal').classList.remove('hidden')" class="px-8 py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 flex items-center gap-3">
                    <span class="material-symbols-outlined">add</span>
                    Add Task
                </button>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Tasks -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-lg shadow-gray-200/30 border border-gray-50">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight">Today's Agenda</h3>
                        <p class="text-sm text-gray-500 font-medium">Tasks extracted from your morning call.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse ($tasks as $task)
                        <div class="flex items-center justify-between p-5 bg-gray-50/50 hover:bg-white rounded-2xl border border-gray-100 hover:border-primary/20 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <form action="{{ route('tasks.complete', $task) }}" method="POST" class="mt-1">
                                    @csrf
                                    <button type="submit" class="w-6 h-6 rounded border {{ $task->status === 'completed' ? 'bg-primary border-primary text-white' : 'border-gray-300 bg-white hover:border-primary' }} flex items-center justify-center transition-colors">
                                        @if($task->status === 'completed')
                                            <span class="material-symbols-outlined text-[16px] font-bold">check</span>
                                        @endif
                                    </button>
                                </form>
                                <div>
                                    <h4 class="font-bold text-gray-900 {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }}">{{ $task->title }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">{{ $task->input_text }}</p>
                                    @if($task->estimated_minutes)
                                    <div class="flex items-center gap-1 mt-2 text-xs font-bold text-primary bg-primary/10 px-2 py-1 rounded w-fit">
                                        <span class="material-symbols-outlined text-[14px]">timer</span>
                                        {{ $task->estimated_minutes }} mins
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <span class="material-symbols-outlined text-5xl text-gray-300 mb-4">task</span>
                            <p class="text-gray-500 font-medium">No tasks yet for today. Wait for your morning call or add one manually!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Task Modal (Simplified for manual entry if needed) -->
<div id="newTaskModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
    <div class="bg-white rounded-[2rem] p-8 max-w-md w-full shadow-2xl relative">
        <button onclick="document.getElementById('newTaskModal').classList.add('hidden')" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600">
            <span class="material-symbols-outlined">close</span>
        </button>
        <h3 class="text-2xl font-black mb-6">Add New Task</h3>
        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Title</label>
                <input type="text" name="title" required class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Details</label>
                <textarea name="input_text" rows="3" required class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring focus:ring-primary/20"></textarea>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Estimated Minutes</label>
                <input type="number" name="estimated_minutes" value="30" min="1" required class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring focus:ring-primary/20">
            </div>
            <button type="submit" class="w-full py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-container">Save Task</button>
        </form>
    </div>
</div>
@endsection
