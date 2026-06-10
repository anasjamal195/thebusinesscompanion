<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\DailyReportService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $tz = $user->timezone;
        $today = now()->setTimezone($tz)->toDateString();

        $currentTasks = Task::where('user_id', $user->id)
            ->where('date', $today)
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('created_at', 'desc')
            ->get();

        $allTasks = Task::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedTasks = $allTasks->groupBy(fn($t) => $t->date ? \Carbon\Carbon::parse($t->date)->format('Y-m-d') : 'no-date');

        $stats = [
            'total' => Task::where('user_id', $user->id)->count(),
            'completed' => Task::where('user_id', $user->id)->where('status', 'completed')->count(),
            'pending' => Task::where('user_id', $user->id)->where('status', 'pending')->count(),
            'today' => $currentTasks->count(),
        ];

        $priorityColors = [
            'high' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
            'medium' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'dot' => 'bg-yellow-500'],
            'low' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
        ];

        $todayCarbon = now()->setTimezone($tz);
        $yesterdayCarbon = now()->setTimezone($tz)->subDay();

        return view('tasks.index', compact(
            'currentTasks', 'groupedTasks', 'stats', 'priorityColors', 'today', 'todayCarbon', 'yesterdayCarbon'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'input_text' => ['required', 'string'],
            'estimated_minutes' => ['required', 'integer', 'min:1'],
            'priority' => ['nullable', 'in:low,medium,high'],
        ]);

        $task = Task::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'input_text' => $validated['input_text'],
            'priority' => $validated['priority'] ?? 'medium',
            'status' => 'pending',
            'date' => now()->setTimezone($request->user()->timezone)->toDateString(),
            'estimated_minutes' => $validated['estimated_minutes'],
            'scheduled_followup_time' => now()->addMinutes($validated['estimated_minutes']),
        ]);

        return back()->with('success', 'Task added successfully.');
    }

    public function complete(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 404);

        $task->update([
            'status' => $task->status === 'completed' ? 'pending' : 'completed',
        ]);

        return back();
    }

    public function markDayCompleted(Request $request, DailyReportService $dailyService)
    {
        $report = $dailyService->generateForUser($request->user());

        if (!$report) {
            return back()->with('error', 'No tasks found for today.');
        }

        return redirect()->route('daily-reports.show', $report)
            ->with('success', 'Day marked as completed! Report generated.');
    }

    public function update(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'input_text' => ['required', 'string'],
            'estimated_minutes' => ['required', 'integer', 'min:1'],
            'priority' => ['nullable', 'in:low,medium,high'],
            'status' => ['nullable', 'in:pending,completed,discarded'],
        ]);

        $task->update($validated);

        return back()->with('success', 'Task updated successfully.');
    }

    public function destroy(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 404);

        $task->delete();

        return back()->with('success', 'Task deleted.');
    }
}
