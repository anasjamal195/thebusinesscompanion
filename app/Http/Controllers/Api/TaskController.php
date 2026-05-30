<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\DailyReportService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::where('user_id', $request->user()->id);

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $tasks = $query->latest()->get();

        return response()->json(['tasks' => $tasks]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'input_text' => ['nullable', 'string'],
            'priority' => ['nullable', 'in:high,medium,low'],
            'estimated_minutes' => ['nullable', 'integer', 'min:1'],
        ]);

        $task = Task::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'input_text' => $validated['input_text'] ?? $validated['title'],
            'priority' => $validated['priority'] ?? 'medium',
            'status' => 'pending',
            'date' => now()->setTimezone($request->user()->timezone ?? 'UTC')->toDateString(),
            'estimated_minutes' => $validated['estimated_minutes'] ?? null,
        ]);

        return response()->json(['task' => $task], 201);
    }

    public function update(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 404);

        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'priority' => ['sometimes', 'in:high,medium,low'],
            'status' => ['sometimes', 'in:pending,completed,discarded'],
            'estimated_minutes' => ['nullable', 'integer', 'min:1'],
        ]);

        $task->update($validated);

        return response()->json(['task' => $task]);
    }

    public function complete(Request $request, Task $task, DailyReportService $dailyService)
    {
        abort_unless($task->user_id === $request->user()->id, 404);

        $newStatus = $task->status === 'completed' ? 'pending' : 'completed';
        $task->update(['status' => $newStatus]);

        if ($newStatus === 'completed' && $dailyService->allTasksDoneForToday($request->user())) {
            $dailyService->generateForUser($request->user());
        }

        return response()->json(['task' => $task]);
    }
}
