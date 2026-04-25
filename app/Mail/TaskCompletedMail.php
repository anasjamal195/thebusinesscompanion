<?php

namespace App\Mail;

use App\Models\Task;
use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class TaskCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $report;

    /**
     * Create a new message instance.
     */
    public function __construct(Task $task, Report $report)
    {
        $this->task = $task;
        $this->report = $report;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Task Completed: ' . $this->task->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.task_completed',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $this->report->loadMissing('task.project');

        $pdf = Pdf::loadView('reports.pdf', [
            'report' => $this->report,
            'task' => $this->report->task,
            'project' => $this->report->task->project,
        ])->setPaper('a4');

        $safeName = preg_replace('/[^a-z0-9\-_]+/i', '-', $this->task->title ?: 'report') ?: 'report';

        return [
            Attachment::fromData(fn () => $pdf->output(), $safeName . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
