<?php

namespace App\Services;

use App\Models\DailyReport;
use App\Models\Task;
use App\Models\User;

class ExecutionScoreService
{
    public function recalculate(User $user): int
    {
        $score = 0;
        $weights = [
            'task_completion' => 35,
            'follow_up_participation' => 20,
            'ai_call_participation' => 20,
            'consistency' => 15,
            'daily_report_completion' => 10,
        ];

        $taskCompletionRate = $this->calculateTaskCompletionRate($user);
        $score += $weights['task_completion'] * $taskCompletionRate;

        $followUpRate = $this->calculateFollowUpRate($user);
        $score += $weights['follow_up_participation'] * $followUpRate;

        $callRate = $this->calculateCallRate($user);
        $score += $weights['ai_call_participation'] * $callRate;

        $consistencyScore = $this->calculateConsistencyScore($user);
        $score += $weights['consistency'] * $consistencyScore;

        $reportRate = $this->calculateReportRate($user);
        $score += $weights['daily_report_completion'] * $reportRate;

        $score = min(100, max(0, (int) round($score)));

        $user->update(['execution_score' => $score]);

        return $score;
    }

    protected function calculateTaskCompletionRate(User $user): float
    {
        $total = Task::where('user_id', $user->id)->count();
        if ($total === 0) {
            return 0;
        }

        $completed = Task::where('user_id', $user->id)->where('status', 'completed')->count();

        return $completed / max($total, 1);
    }

    protected function calculateFollowUpRate(User $user): float
    {
        $recent = 30;
        $totalCalls = $user->calls()
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays($recent))
            ->count();

        $expectedCalls = $recent;
        if ($totalCalls === 0) {
            return 0;
        }

        return min(1, $totalCalls / max($expectedCalls, 1));
    }

    protected function calculateCallRate(User $user): float
    {
        $recent = 30;
        $totalCalls = $user->calls()
            ->where('created_at', '>=', now()->subDays($recent))
            ->count();

        $expectedCalls = $recent;
        if ($totalCalls === 0) {
            return 0;
        }

        return min(1, $totalCalls / max($expectedCalls, 1));
    }

    protected function calculateConsistencyScore(User $user): float
    {
        $app = app(AchievementService::class);
        $streak = $app->calculateStreak($user);

        return min(1, $streak / 90);
    }

    protected function calculateReportRate(User $user): float
    {
        $recent = 30;
        $reportCount = DailyReport::where('user_id', $user->id)
            ->where('report_date', '>=', now()->subDays($recent)->toDateString())
            ->count();

        return min(1, $reportCount / max($recent, 1));
    }
}
