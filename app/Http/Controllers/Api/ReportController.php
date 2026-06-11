<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\DailyReport;
use App\Models\Report;
use App\Models\User;
use App\Services\DailyReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function indexDaily(Request $request)
    {
        $dailyReports = DailyReport::where('user_id', $request->user()->id)
            ->latest('report_date')
            ->get();

        return response()->json(['daily_reports' => $dailyReports]);
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

    public function shareReport(Request $request, DailyReport $dailyReport)
    {
        abort_unless($dailyReport->user_id === $request->user()->id, 404);

        $validated = $request->validate([
            'visibility' => 'required|in:public,followers',
            'hidden_task_ids' => 'nullable|array',
            'hidden_task_ids.*' => 'integer',
        ]);

        $user = $request->user();
        $tasksData = $dailyReport->tasks_data ?? [];

        $hiddenIds = $validated['hidden_task_ids'] ?? [];

        $completedCount = $dailyReport->completed_tasks;
        $totalCount = $dailyReport->total_tasks;
        $score = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;

        $visibleTasks = array_filter($tasksData, function ($task) use ($hiddenIds) {
            return !in_array($task['id'] ?? null, $hiddenIds);
        });

        $content = $this->generateShareContent($user, $dailyReport, $completedCount, $totalCount, $score, $visibleTasks, $hiddenIds, $tasksData);

        $post = CommunityPost::create([
            'user_id' => $user->id,
            'type' => 'progress',
            'content' => $content,
            'visibility' => $validated['visibility'],
            'hidden_tasks' => $hiddenIds,
            'daily_report_id' => $dailyReport->id,
            'metadata' => [
                'report_date' => $dailyReport->report_date->toDateString(),
                'completed' => $completedCount,
                'total' => $totalCount,
                'score' => $score,
                'ai_summary' => $dailyReport->summary,
            ],
        ]);

        return response()->json(['post' => $post], 201);
    }

    protected function generateShareContent(User $user, DailyReport $report, int $completed, int $total, int $score, array $visibleTasks, array $hiddenIds, array $allTasks): string
    {
        $aiSummary = $report->summary ?? '';

        try {
            $openRouter = app(\App\Services\OpenRouterService::class);
            $taskSummary = collect($allTasks)->map(fn($t) => ($t['title'] ?? 'Task') . ' (' . ($t['status'] ?? 'pending') . ')')->implode(', ');

            $hiddenCount = count($hiddenIds);
            $hiddenNote = $hiddenCount > 0 ? " (with {$hiddenCount} task(s) hidden)" : '';

            $prompt = <<<PROMPT
You are a user sharing their daily productivity progress on a social feed. Write a warm, first-person sharing post (2-4 sentences) that:

- Starts with "I completed {$completed} of {$total} tasks today{$hiddenNote}!"
- Mentions the completion score of {$score}%
- Includes a brief reflection on the day — what went well, or motivation for tomorrow
- Uses first person ("I", "my", "me")
- Ends with a positive note or question to engage the community
- Keep it under 150 words, natural and conversational, no hashtags

Tasks: {$taskSummary}

AI summary: {$aiSummary}
PROMPT;

            $messages = [
                ['role' => 'system', 'content' => 'You write short, warm, first-person productivity posts. Output ONLY plain text — NO markdown, NO asterisks, NO bold, NO italics, NO JSON, NO extra commentary. Just plain sentences.'],
                ['role' => 'user', 'content' => $prompt],
            ];

            $response = $openRouter->chatCompletion($messages, false, 300);
            if ($response && $response->successful()) {
                $aiContent = trim($response->json('choices.0.message.content', ''));
                $aiContent = preg_replace('/\*+/', '', $aiContent);
                $aiContent = preg_replace('/#+/', '', $aiContent);
                $aiContent = preg_replace('/`+/', '', $aiContent);
                $aiContent = preg_replace('/~~+/', '', $aiContent);
                if ($aiContent !== '') {
                    return trim($aiContent);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to generate AI share content, using fallback.', ['error' => $e->getMessage()]);
        }

        $hiddenNote = count($hiddenIds) > 0 ? ' (some tasks hidden)' : '';
        $summary = $aiSummary ?: "Keep pushing forward!";
        return "I completed {$completed} of {$total} tasks today{$hiddenNote} — that's {$score}% done! {$summary}";
    }
}
