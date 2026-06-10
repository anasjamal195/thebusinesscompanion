<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\DailyReport;
use App\Models\Report;
use App\Models\User;
use App\Services\DailyReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        event('daily-report.generated', [$request->user()->id]);

        return redirect()->route('daily-reports.show', $report)
            ->with('success', 'Daily report generated successfully!');
    }

    public function shareReport(Request $request, DailyReport $dailyReport)
    {
        abort_unless($dailyReport->user_id === $request->user()->id, 404);

        $validated = $request->validate([
            'visibility' => 'required|in:public,followers',
            'hidden_task_ids' => 'nullable',
        ]);

        $user = $request->user();
        $tasksData = $dailyReport->tasks_data ?? [];

        // hidden_task_ids comes as JSON string from the front-end
        $hiddenIds = [];
        if (!empty($validated['hidden_task_ids'])) {
            $decoded = json_decode($validated['hidden_task_ids'], true);
            if (is_array($decoded)) {
                $hiddenIds = $decoded;
            }
        }

        $completedCount = $dailyReport->completed_tasks;
        $totalCount = $dailyReport->total_tasks;
        $score = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;

        // Build visible tasks list for the content
        $visibleTasks = array_filter($tasksData, function ($task) use ($hiddenIds) {
            return !in_array($task['id'] ?? null, $hiddenIds);
        });

        // Generate first-person AI content
        $content = $this->generateShareContent($user, $dailyReport, $completedCount, $totalCount, $score, $visibleTasks, $hiddenIds, $tasksData);

        CommunityPost::create([
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

        return redirect()->route('community.feed')
            ->with('success', 'Progress shared to feed!');
    }

    protected function generateShareContent(User $user, DailyReport $report, int $completed, int $total, int $score, array $visibleTasks, array $hiddenIds, array $allTasks): string
    {
        $aiSummary = $report->summary ?? '';

        // Try to generate AI first-person content using OpenRouter
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

        // Fallback first-person content
        $hiddenNote = count($hiddenIds) > 0 ? ' (some tasks hidden)' : '';
        $summary = $aiSummary ?: "Keep pushing forward!";
        return "I completed {$completed} of {$total} tasks today{$hiddenNote} — that's {$score}% done! {$summary}";
    }
}
