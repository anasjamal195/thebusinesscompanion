@php
    use App\Models\Call;
    use Carbon\Carbon;

    $title = 'Dashboard';
    $pageTitle = 'Today\'s Tasks';
    $activeNav = 'dashboard';

    $user = auth()->user();
    $today = now()->setTimezone($user->timezone)->toDateString();

    $morningTimeFormatted = $user->morning_call_time
        ? Carbon::createFromFormat('H:i:s', $user->morning_call_time)->format('g:i A')
        : 'Not set';

    $todayCalls = Call::where('user_id', $user->id)
        ->whereDate('created_at', $today)
        ->orderBy('created_at', 'desc')
        ->get();

    $morningCallDone = $todayCalls->contains(fn ($c) => ($c->metadata['call_type'] ?? '') === 'morning');
    $lastCall = $todayCalls->first();
    $followUpCount = $todayCalls->filter(fn ($c) => ($c->metadata['call_type'] ?? '') === 'followup')->count();

    $priorityColors = [
        'high' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
        'medium' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'dot' => 'bg-yellow-500'],
        'low' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
    ];

    $callStatusBadge = function ($status) {
        return match ($status) {
            'completed' => 'bg-green-100 text-green-700',
            'in-progress', 'initiated', 'initiating' => 'bg-blue-100 text-blue-700',
            'failed' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-600',
        };
    };
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
                    <span>Scheduled for {{ $morningTimeFormatted }}</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight">
                    Hello, <span class="text-primary">{{ explode(' ', $user->name)[0] }}</span>.
                </h2>
                <p class="text-lg text-gray-500 max-w-xl font-medium">
                    You have <span class="text-gray-900 font-bold">{{ $pendingCount }}</span> pending tasks for today.
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

    <!-- Call Status Strip -->
    <div class="bg-white rounded-[2rem] p-5 shadow-lg shadow-gray-200/30 border border-gray-50 flex flex-wrap items-center gap-4 text-sm">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-gray-400">phone_in_talk</span>
            <span class="font-bold text-gray-700">Calls Today:</span>
        </div>

        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full {{ $morningCallDone ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
            <span class="font-medium text-gray-600">Morning: {{ $morningCallDone ? 'Done' : 'Pending' }}</span>
        </div>

        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] text-gray-400">repeat</span>
            <span class="font-medium text-gray-600">{{ $followUpCount }} follow-up(s)</span>
        </div>

        @if($lastCall)
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-gray-400">history</span>
                <span class="font-medium text-gray-600">Last: {{ $lastCall->created_at->setTimezone($user->timezone)->format('g:i A') }}</span>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $callStatusBadge($lastCall->status) }}">
                {{ $lastCall->status }}
            </span>
        @else
            <span class="text-gray-400 font-medium">No calls yet today</span>
        @endif
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
                    <div class="flex items-center gap-3 text-xs font-bold">
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> High</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-yellow-500"></span> Medium</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Low</span>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse ($tasks as $task)
                        @php
                            $pc = $priorityColors[$task->priority] ?? $priorityColors['medium'];
                        @endphp
                        <div class="flex items-center justify-between p-5 bg-gray-50/50 hover:bg-white rounded-2xl border border-gray-100 hover:border-primary/20 hover:shadow-lg transition-all duration-300 {{ $task->status === 'discarded' ? 'opacity-50' : '' }}">
                            <div class="flex items-start gap-4">
                                @if($task->status !== 'discarded')
                                <form action="{{ route('tasks.complete', $task) }}" method="POST" class="mt-1">
                                    @csrf
                                    <button type="submit" class="w-6 h-6 rounded border {{ $task->status === 'completed' ? 'bg-primary border-primary text-white' : 'border-gray-300 bg-white hover:border-primary' }} flex items-center justify-center transition-colors">
                                        @if($task->status === 'completed')
                                            <span class="material-symbols-outlined text-[16px] font-bold">check</span>
                                        @endif
                                    </button>
                                </form>
                                @else
                                <div class="mt-1 w-6 h-6 rounded border border-gray-200 bg-gray-100 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[14px] text-gray-400">close</span>
                                </div>
                                @endif
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-gray-900 {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }} {{ $task->status === 'discarded' ? 'text-gray-400 line-through' : '' }}">{{ $task->title }}</h4>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $pc['bg'] }} {{ $pc['text'] }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $pc['dot'] }}"></span>
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                        @if($task->status === 'discarded')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-200 text-gray-500">Discarded</span>
                                        @endif
                                    </div>
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

        <!-- Right Column: Daily Progress -->
        <div class="space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-lg shadow-gray-200/30 border border-gray-50">
                <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6">Daily Progress</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-2xl border border-green-100">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">check_circle</span>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-green-700">Completed</p>
                                <p class="text-xs text-green-500">{{ $totalCount > 0 ? round(($completedCount / max($totalCount - $discardedCount, 1)) * 100) : 0 }}% of tasks</p>
                            </div>
                        </div>
                        <span class="text-2xl font-black text-green-600">{{ $completedCount }}</span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-2xl border border-yellow-100">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">pending</span>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-yellow-700">Pending</p>
                                <p class="text-xs text-yellow-500">{{ $pendingCount }} task(s) remaining</p>
                            </div>
                        </div>
                        <span class="text-2xl font-black text-yellow-600">{{ $pendingCount }}</span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">do_not_disturb</span>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-gray-700">Discarded</p>
                                <p class="text-xs text-gray-500">{{ $discardedCount }} task(s) skipped</p>
                            </div>
                        </div>
                        <span class="text-2xl font-black text-gray-600">{{ $discardedCount }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('reports.index') }}" class="block bg-white rounded-[2.5rem] p-8 shadow-lg shadow-gray-200/30 border border-gray-50 hover:border-primary/20 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center gap-4 mb-4">
                    <span class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[28px]">summarize</span>
                    </span>
                    <div>
                        <h3 class="text-lg font-black text-gray-900 tracking-tight">Reports</h3>
                        <p class="text-xs text-gray-500 font-medium">View daily summaries</p>
                    </div>
                </div>
                <span class="flex items-center gap-2 text-sm font-bold text-primary group-hover:gap-3 transition-all">
                    View All Reports
                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                </span>
            </a>
        </div>
    </div>
</div>

<!-- New Task Modal -->
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
