@php
    use App\Models\Call;
    use Carbon\Carbon;

    $title = 'Dashboard';
    $pageTitle = 'Overview';
    $activeNav = 'dashboard';

    $user = auth()->user();
    $tz = $user->timezone;
    $today = now()->setTimezone($tz)->toDateString();

    $morningTimeFormatted = $user->morning_call_time
        ? Carbon::createFromFormat('H:i:s', $user->morning_call_time)->format('g:i A')
        : 'Not set';

    $morningCallDone = $user->last_morning_call_date === $today;

    $tzStart = now()->setTimezone($tz)->startOfDay()->setTimezone('UTC');
    $tzEnd   = now()->setTimezone($tz)->endOfDay()->setTimezone('UTC');
    $todayCalls = Call::where('user_id', $user->id)
        ->whereBetween('created_at', [$tzStart, $tzEnd])
        ->orderBy('created_at', 'desc')
        ->get();

    $lastCall = $todayCalls->first();
    $followUpCount = $todayCalls->filter(fn ($c) => ($c->metadata['call_type'] ?? '') === 'followup')->count();

    $priorityColors = [
        'high' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
        'medium' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'dot' => 'bg-yellow-500'],
        'low' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
    ];
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="inline-flex items-center gap-2 px-3 py-2 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="inline-flex items-center gap-2 px-3 py-2 bg-red-50 text-red-700 rounded-lg text-sm font-medium border border-red-200">
            <span class="material-symbols-outlined text-[18px]">error</span>
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Welcome Strip --}}
    <div class="flex items-center justify-between bg-white rounded-xl border border-gray-200 px-6 py-4 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-[24px]">waving_hand</span>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">Good {{ now()->setTimezone($tz)->format('A') == 'AM' ? 'morning' : 'afternoon' }}, {{ explode(' ', $user->name)[0] }}.</h2>
                <p class="text-sm text-gray-500">{{ $pendingCount }} task{{ $pendingCount !== 1 ? 's' : '' }} pending today &middot; Morning call {{ $morningCallDone ? 'completed' : 'at ' . $morningTimeFormatted }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <form action="{{ route('calls.request') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">{{ $user->calling_preference === 'app' ? 'smartphone' : 'phone_in_talk' }}</span>
                    {{ $user->calling_preference === 'app' ? 'Call on App' : 'Request Call' }}
                </button>
            </form>
            <form action="{{ route('tasks.mark-day-completed') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">celebration</span>
                    Mark Day Completed
                </button>
            </form>
            <button onclick="document.getElementById('newTaskModal').classList.remove('hidden')" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">add</span>
                New Task
            </button>
        </div>
    </div>

    {{-- Low Balance Banner --}}
    @php
        $minRate = \App\Models\MonetizationSetting::getInstance()->per_minute_rate;
        $credits = auth()->user()->credits;
    @endphp
    @if($credits <= 0 || $credits < $minRate)
        <div class="flex items-center gap-3 px-5 py-3 rounded-xl bg-red-50 border border-red-200 shadow-sm">
            <span class="material-symbols-outlined text-red-500 text-[24px]">error</span>
            <div class="flex-1">
                <p class="text-sm font-semibold text-red-800">Out of Balance</p>
                <p class="text-xs text-red-600">Your credits are depleted. You will not receive any calls until you recharge.</p>
            </div>
            <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">bolt</span>
                Recharge Now
            </a>
        </div>
    @elseif($credits < 2)
        <div class="flex items-center gap-3 px-5 py-3 rounded-xl bg-orange-50 border border-orange-200 shadow-sm">
            <span class="material-symbols-outlined text-orange-500 text-[24px]">warning</span>
            <div class="flex-1">
                <p class="text-sm font-semibold text-orange-800">Low Balance</p>
                <p class="text-xs text-orange-600">Your balance is running low ({{ number_format($credits, 2) }} credits). Recharge to continue receiving calls.</p>
            </div>
            <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-orange-600 text-white text-sm font-semibold hover:bg-orange-700 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">bolt</span>
                Recharge
            </a>
        </div>
    @endif

    {{-- Metrics Row --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">check_circle</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $completedCount }}</p>
                    <p class="text-xs text-gray-500">Completed</p>
                </div>
            </div>
            <div class="mt-2 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 rounded-full" style="width: {{ $totalCount > 0 ? min(100, round(($completedCount / max($totalCount - $discardedCount, 1)) * 100)) : 0 }}%"></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">pending</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
                    <p class="text-xs text-gray-500">Pending</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">phone_in_talk</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $todayCalls->count() }}</p>
                    <p class="text-xs text-gray-500">Calls Today</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gray-50 text-gray-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">trending_up</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($user->credits, 0) }}</p>
                    <p class="text-xs text-gray-500">Credits</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Tasks Column --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <div>
                        <h3 class="font-semibold text-gray-900">Today's Agenda</h3>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $totalCount }} task{{ $totalCount !== 1 ? 's' : '' }} for today</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-gray-500">
                        <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> High</span>
                        <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Med</span>
                        <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Low</span>
                    </div>
                </div>
                <div class="p-1">
                    @forelse ($tasks as $task)
                        @php $pc = $priorityColors[$task->priority] ?? $priorityColors['medium']; @endphp
                        <div class="flex items-start gap-3 px-4 py-3 rounded-lg mx-1 {{ $task->status === 'discarded' ? 'opacity-50' : 'hover:bg-gray-50' }} transition-colors {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
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
                                <div class="flex items-center gap-2">
                                    <h4 class="text-sm font-medium text-gray-900 {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }} {{ $task->status === 'discarded' ? 'text-gray-400 line-through' : '' }}">{{ $task->title }}</h4>
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-medium {{ $pc['bg'] }} {{ $pc['text'] }}">
                                        <span class="w-1 h-1 rounded-full {{ $pc['dot'] }}"></span>
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                    @if($task->status === 'discarded')
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-500">Discarded</span>
                                    @endif
                                </div>
                                @if($task->input_text)
                                    <p class="text-xs text-gray-500 mt-0.5 line-clamp-1">{{ $task->input_text }}</p>
                                @endif
                                <div class="flex items-center gap-3 mt-1.5">
                                    @if($task->estimated_minutes)
                                    <span class="inline-flex items-center gap-0.5 text-[11px] font-medium text-gray-400">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                                        {{ $task->estimated_minutes }} min
                                    </span>
                                    @endif
                                    @if($task->scheduled_followup_time && $task->status === 'pending')
                                        @php $nextCheck = \Carbon\Carbon::parse($task->scheduled_followup_time, 'UTC')->setTimezone($user->timezone); @endphp
                                        <span class="inline-flex items-center gap-0.5 text-[11px] font-medium text-purple-500">
                                            <span class="material-symbols-outlined text-[14px]">alarm</span>
                                            Follow-up {{ $nextCheck->format('g:i A') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <span class="material-symbols-outlined text-4xl text-gray-300 mb-3">checklist</span>
                            <p class="text-sm text-gray-500 font-medium">No tasks yet today.</p>
                            <p class="text-xs text-gray-400 mt-1">Complete a morning call or add a task manually.</p>
                        </div>
                    @endforelse
                </div>
                @if($tasks->isNotEmpty())
                <div class="border-t border-gray-100 px-5 py-3">
                    <form action="{{ route('reports.daily.generate') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-primary hover:text-primary-container transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">auto_awesome</span>
                            Generate Daily Report
                        </button>
                    </form>
                </div>
                @endif
            </div>

            {{-- Recent Activity --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Today's Activity</h3>
                    @if($lastCall)
                        <span class="text-xs text-gray-500">{{ $todayCalls->count() }} call{{ $todayCalls->count() !== 1 ? 's' : '' }}</span>
                    @endif
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-50 text-green-600">
                            <span class="material-symbols-outlined text-[18px]">{{ $morningCallDone ? 'check_circle' : 'pending' }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Morning Call</p>
                            <p class="text-xs text-gray-500">{{ $morningCallDone ? 'Completed at ' . ($lastCall ? $lastCall->created_at->setTimezone($user->timezone)->format('g:i A') : 'today') : 'Pending at ' . $morningTimeFormatted }}</p>
                        </div>
                        <span class="text-xs font-medium {{ $morningCallDone ? 'text-green-600' : 'text-yellow-600' }}">{{ $morningCallDone ? 'Done' : 'Pending' }}</span>
                    </div>
                    @if($followUpCount > 0)
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600">
                            <span class="material-symbols-outlined text-[18px]">repeat</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Follow-ups</p>
                            <p class="text-xs text-gray-500">{{ $followUpCount }} follow-up call{{ $followUpCount !== 1 ? 's' : '' }} today</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-3 space-y-1">
                    <button onclick="document.getElementById('newTaskModal').classList.remove('hidden')" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="material-symbols-outlined text-[20px] text-primary">add_circle</span>
                        Create Task
                    </button>
                    <a href="{{ route('community.feed') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="material-symbols-outlined text-[20px] text-primary">post_add</span>
                        Share Progress
                    </a>
                    <a href="{{ route('calendar.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="material-symbols-outlined text-[20px] text-primary">calendar_month</span>
                        View Calendar
                    </a>
                    <a href="{{ route('profile.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="material-symbols-outlined text-[20px] text-primary">person</span>
                        My Profile
                    </a>
                    <a href="{{ route('reports.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <span class="material-symbols-outlined text-[20px] text-primary">summarize</span>
                        View Reports
                    </a>
                </div>
            </div>

            {{-- Daily Progress Card --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Daily Progress</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                            </span>
                            <span class="text-sm font-medium text-gray-700">Completed</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900">{{ $completedCount }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">pending</span>
                            </span>
                            <span class="text-sm font-medium text-gray-700">Pending</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900">{{ $pendingCount }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-gray-50 text-gray-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">do_not_disturb</span>
                            </span>
                            <span class="text-sm font-medium text-gray-700">Skipped</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900">{{ $discardedCount }}</span>
                    </div>
                </div>
            </div>

            {{-- Reports Link --}}
            <a href="{{ route('reports.index') }}" class="block bg-white rounded-xl border border-gray-200 shadow-sm p-4 hover:border-gray-300 hover:shadow-md transition-all group">
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]">summarize</span>
                    </span>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Reports</p>
                        <p class="text-xs text-gray-500">View daily summaries</p>
                    </div>
                    <span class="material-symbols-outlined text-gray-300 group-hover:text-primary transition-colors text-[20px]">chevron_right</span>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- New Task Modal --}}
<div id="newTaskModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/20 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full relative border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">New Task</h3>
            <button onclick="document.getElementById('newTaskModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 p-1 rounded hover:bg-gray-100 transition-colors">
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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Minutes</label>
                <input type="number" name="estimated_minutes" value="30" min="1" required class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="button" onclick="document.getElementById('newTaskModal').classList.add('hidden')" class="flex-1 px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm">
                    Save Task
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
