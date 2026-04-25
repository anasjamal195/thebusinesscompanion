<?php

namespace App\Listeners;

use App\Events\TaskCompleted;
use App\Mail\TaskCompletedMail;
use App\Models\Report;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTaskCompletedEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCompleted $event): void
    {
        if ($event->reportId) {
            $report = Report::find($event->reportId);
            if ($report && $event->task->user) {
                Mail::to($event->task->user->email)->send(new TaskCompletedMail($event->task, $report));
            }
        }
    }
}
