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

        $previousTasks = Task::where('user_id', $user->id)
            ->where('date', '<', $today)
            ->orderBy('date', 'desc')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->paginate(25);

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

        return view('tasks.index', compact(
            'currentTasks', 'previousTasks', 'stats', 'priorityColors', 'today'
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

    public function complete(Request $request, Task $task, DailyReportService $dailyService)
    {
        abort_unless($task->user_id === $request->user()->id, 404);

        $task->update([
            'status' => $task->status === 'completed' ? 'pending' : 'completed',
        ]);

        if ($dailyService->allTasksDoneForToday($request->user())) {
            $dailyService->generateForUser($request->user());
        }

        return back();
    }

    public function update(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'input_text' => ['required', 'string'],
            'estimated_minutes' => ['required', 'integer', 'min:1'],
            'priority' => ['nullable', 'in:low,medium,high'],
        ]);

        $task->update([
            ...$validated,
            'scheduled_followup_time' => now()->addMinutes($validated['estimated_minutes']),
        ]);

        return back();
    }

    public function destroy(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 404);

        $task->delete();

        return back()->with('success', 'Task deleted.');
    }
}
