<?php

namespace App\Listeners;

use App\Events\TaskCompleted;
use App\Models\DailyReport;
use App\Services\AchievementService;
use App\Services\ExecutionScoreService;

class AchievementListener
{
    public function __construct(
        protected AchievementService $achievements,
        protected ExecutionScoreService $scores,
    ) {}

    public function handleTaskCompleted(TaskCompleted $event): void
    {
        $user = $event->task->user;

        $this->achievements->checkTaskMilestones($user);
        $this->scores->recalculate($user);
    }

    public function handleDailyReportGenerated($userId): void
    {
        $user = \App\Models\User::find($userId);
        if (!$user) {
            return;
        }

        $this->achievements->checkReportMilestones($user);
        $this->achievements->checkCompletionMilestones($user);
        $this->achievements->checkStreakMilestones($user);
        $this->scores->recalculate($user);
    }

    public function handleCallCompleted($userId): void
    {
        $user = \App\Models\User::find($userId);
        if (!$user) {
            return;
        }

        $this->achievements->checkCallMilestones($user);
        $this->scores->recalculate($user);
    }

    public function subscribe(\Illuminate\Events\Dispatcher $events): array
    {
        return [
            TaskCompleted::class => 'handleTaskCompleted',
            'daily-report.generated' => 'handleDailyReportGenerated',
            'call.completed' => 'handleCallCompleted',
        ];
    }
}
