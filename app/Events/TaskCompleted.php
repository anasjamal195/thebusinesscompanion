<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Task $task,
        public readonly string $finalText,
        public readonly ?array $structured = null,
        public readonly ?int $reportId = null,
    ) {
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('task.' . $this->task->id);
    }

    public function broadcastAs(): string
    {
        return 'task.completed';
    }

    public function broadcastWith(): array
    {
        return [
            'task_id' => $this->task->id,
            'status' => $this->task->status,
            'final_text' => $this->finalText,
            'structured' => $this->structured,
            'report_id' => $this->reportId,
        ];
    }
}

