<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\Report;
use App\Services\DailyReportService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $taskReports = Report::whereHas('task', function ($q) use ($request) {
            $q->where('user_id', $request->user()->id);
        })->with('task')->latest()->get();

        $dailyReports = DailyReport::where('user_id', $request->user()->id)
            ->latest('report_date')
            ->get();

        $allReports = collect()
            ->merge($taskReports->map(fn ($r) => [
                'id' => 'task_' . $r->id,
                'type' => 'task',
                'source_id' => $r->id,
                'title' => $r->task?->title ?? 'Task Report',
                'summary' => $r->summary,
                'date' => $r->created_at,
                'route' => route('reports.show', $r),
            ]))
            ->merge($dailyReports->map(fn ($r) => [
                'id' => 'daily_' . $r->id,
                'type' => 'daily',
                'source_id' => $r->id,
                'title' => 'Daily Summary — ' . $r->report_date->format('M j, Y'),
                'summary' => $r->summary,
                'date' => $r->created_at,
                'route' => route('daily-reports.show', $r),
            ]))
            ->sortByDesc('date')
            ->values();

        return view('reports.index', [
            'allReports' => $allReports,
            'title' => 'Reports',
            'pageTitle' => 'Reports',
            'activeNav' => 'reports',
        ]);
    }

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

    public function showDaily(Request $request, DailyReport $dailyReport)
    {
        abort_unless($dailyReport->user_id === $request->user()->id, 404);

        return view('reports.daily-show', [
            'report' => $dailyReport,
            'title' => 'Daily Report',
            'pageTitle' => 'Daily Report',
            'activeNav' => 'reports',
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

    public function generateDaily(Request $request, DailyReportService $service)
    {
        $report = $service->generateForUser($request->user());

        if (!$report) {
            return redirect()->route('dashboard')->with('error', 'No tasks found for today.');
        }

        return redirect()->route('daily-reports.show', $report)
            ->with('success', 'Daily report generated successfully!');
    }
}
