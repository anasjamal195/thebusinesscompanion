<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\Report;
use App\Services\DailyReportService;
use Illuminate\Http\Request;

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

        return response()->json([
            'task_reports' => $taskReports,
            'daily_reports' => $dailyReports,
        ]);
    }

    public function show(Request $request, Report $report)
    {
        $report->loadMissing('task.project');
        abort_unless($report->task && $report->task->user_id === $request->user()->id, 404);

        return response()->json(['report' => $report]);
    }

    public function showDaily(Request $request, DailyReport $dailyReport)
    {
        abort_unless($dailyReport->user_id === $request->user()->id, 404);

        return response()->json(['daily_report' => $dailyReport]);
    }

    public function pdf(Request $request, Report $report)
    {
        $report->loadMissing('task.project');
        abort_unless($report->task && $report->task->user_id === $request->user()->id, 404);

        $user = $request->user();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', [
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
            return response()->json([
                'message' => 'No tasks found for today.',
            ], 404);
        }

        return response()->json(['daily_report' => $report]);
    }
}
