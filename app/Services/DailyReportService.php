<?php

namespace App\Services;

use App\Models\DailyReport;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DailyReportService
{
    public function generateForUser(User $user, ?Carbon $date = null): ?DailyReport
    {
        $date = $date ?: now()->setTimezone($user->timezone);
        $dateStr = $date->toDateString();

        $tasks = Task::where('user_id', $user->id)
            ->whereDate('date', $dateStr)
            ->get();

        if ($tasks->isEmpty()) {
            Log::info("DailyReportService: No tasks for User {$user->id} on {$dateStr} — skipping.");
            return null;
        }

        $totalCount = $tasks->count();
        $completedCount = $tasks->where('status', 'completed')->count();
        $pendingCount = $tasks->where('status', 'pending')->count();
        $discardedCount = $tasks->where('status', 'discarded')->count();

        $tasksData = $tasks->map(fn (Task $t) => [
            'id' => $t->id,
            'title' => $t->title,
            'priority' => $t->priority,
            'status' => $t->status,
            'estimated_minutes' => $t->estimated_minutes,
            'details' => $t->input_text,
        ])->toArray();

        $summary = $this->generateSummary($user, $tasksData);

        $report = DailyReport::updateOrCreate(
            ['user_id' => $user->id, 'report_date' => $dateStr],
            [
                'summary' => $summary,
                'tasks_data' => $tasksData,
                'total_tasks' => $totalCount,
                'completed_tasks' => $completedCount,
                'pending_tasks' => $pendingCount,
                'discarded_tasks' => $discardedCount,
            ]
        );

        Log::info("DailyReportService: Generated daily report for User {$user->id} on {$dateStr}", [
            'total' => $totalCount,
            'completed' => $completedCount,
            'pending' => $pendingCount,
            'discarded' => $discardedCount,
        ]);

        return $report;
    }

    public function allTasksDoneForToday(User $user, ?Carbon $date = null): bool
    {
        $date = $date ?: now()->setTimezone($user->timezone);
        $dateStr = $date->toDateString();

        $pendingCount = Task::where('user_id', $user->id)
            ->whereDate('date', $dateStr)
            ->where('status', 'pending')
            ->count();

        return $pendingCount === 0;
    }

    protected function generateSummary(User $user, array $tasksData): ?string
    {
        if (empty($tasksData)) {
            return null;
        }

        $taskLines = '';
        foreach ($tasksData as $i => $t) {
            $statusEmoji = match ($t['status']) {
                'completed' => '✅',
                'pending' => '⏳',
                'discarded' => '❌',
                default => '📝',
            };
            $taskLines .= ($i + 1) . ". {$statusEmoji} {$t['title']}" .
                ($t['details'] ? " — {$t['details']}" : '') .
                " ({$t['status']}, {$t['priority']} priority" .
                ($t['estimated_minutes'] ? ", {$t['estimated_minutes']} min" : '') .
                ")\n";
        }

        $completed = array_filter($tasksData, fn ($t) => $t['status'] === 'completed');
        $pending = array_filter($tasksData, fn ($t) => $t['status'] === 'pending');
        $discarded = array_filter($tasksData, fn ($t) => $t['status'] === 'discarded');

        $prompt = <<<PROMPT
You are a friendly productivity assistant summarizing a user's day.

Below is the user's task list for today.

{$taskLines}

Write a warm, concise daily summary (2-4 sentences) that:
- Celebrates what they accomplished ({count($completed)} completed)
- Acknowledges what's still pending ({count($pending)} pending) or was skipped ({count($discarded)} discarded)
- Encourages them for tomorrow
- Sounds natural and human — like a friend reviewing their day

Keep it under 100 words. Just the summary text, no JSON.
PROMPT;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openrouter.api_key'),
                'HTTP-Referer' => config('app.url'),
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-chat',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 200,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'] ?? null;
                return $content ? trim($content) : null;
            }

            Log::warning("DailyReportService: OpenRouter summary request failed", [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Exception $e) {
            Log::error("DailyReportService: Exception generating summary", [
                'message' => $e->getMessage(),
            ]);
        }

        // Fallback summary if AI fails
        $summary = "Today you completed {$this->countLabel(count($completed), 'task')}";
        if (!empty($pending)) {
            $summary .= ", with {$this->countLabel(count($pending), 'task')} still pending";
        }
        if (!empty($discarded)) {
            $summary .= " and {$this->countLabel(count($discarded), 'task')} skipped";
        }
        $summary .= ". Keep up the great work!";

        return $summary;
    }

    private function countLabel(int $count, string $noun): string
    {
        return "{$count} {$noun}" . ($count !== 1 ? 's' : '');
    }
}
