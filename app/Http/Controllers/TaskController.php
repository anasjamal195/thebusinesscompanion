<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'input_text' => ['required', 'string'],
            'estimated_minutes' => ['required', 'integer', 'min:1'],
        ]);

        $task = Task::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'input_text' => $validated['input_text'],
            'priority' => 'medium',
            'status' => 'pending',
            'date' => today(),
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

    public function update(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'input_text' => ['required', 'string'],
            'estimated_minutes' => ['required', 'integer', 'min:1'],
        ]);

        $task->update([
            ...$validated,
            'scheduled_followup_time' => now()->addMinutes($validated['estimated_minutes']),
        ]);

        return back();
    }
}
