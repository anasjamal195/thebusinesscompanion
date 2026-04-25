<?php

use App\Models\Task;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('task.{taskId}', function ($user, int $taskId) {
    $task = Task::query()->find($taskId);
    return $task && (int) $task->user_id === (int) $user->id;
});

