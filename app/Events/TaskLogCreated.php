<?php

namespace App\Events;

use App\Models\TaskLog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskLogCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly TaskLog $log)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('task.' . $this->log->task_id);
    }

    public function broadcastAs(): string
    {
        return 'task.log';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->log->id,
            'task_id' => $this->log->task_id,
            'step' => $this->log->step,
            'message' => $this->log->message,
            'status' => $this->log->status,
            'created_at' => optional($this->log->created_at)->toISOString(),
        ];
    }
}

