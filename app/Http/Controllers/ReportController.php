<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function show(Request $request, Report $report)
    {
        $report->loadMissing('task.project');
        abort_unless($report->task && $report->task->user_id === $request->user()->id, 404);

        return view('reports.show', [
            'report' => $report,
            'task' => $report->task,
            'project' => $report->task->project,
            'title' => 'Report',
            'pageTitle' => 'Report',
            'activeNav' => 'reports',
            'activeProjectId' => (string) ($report->task->project_id ?? ''),
            'activeTaskId' => (string) ($report->task_id ?? ''),
        ]);
    }

    public function pdf(Request $request, Report $report)
    {
        $report->loadMissing('task.project');
        abort_unless($report->task && $report->task->user_id === $request->user()->id, 404);

        $pdf = Pdf::loadView('reports.pdf', [
            'report' => $report,
            'task' => $report->task,
            'project' => $report->task->project,
        ])->setPaper('a4');

        $safeName = preg_replace('/[^a-z0-9\\-_]+/i', '-', $report->task->title ?: 'report') ?: 'report';
        return $pdf->download($safeName . '.pdf');
    }
}
