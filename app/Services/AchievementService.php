<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\DailyReport;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AchievementService
{
    public function checkTaskMilestones(User $user): ?Achievement
    {
        $count = Task::where('user_id', $user->id)->where('status', 'completed')->count();

        $milestones = [
            'first_task' => 1,
            '10_tasks' => 10,
            '100_tasks' => 100,
            '1000_tasks' => 1000,
        ];

        foreach ($milestones as $key => $threshold) {
            if ($count >= $threshold) {
                $achievement = Achievement::where('key', $key)->first();
                if ($achievement && !$user->achievements()->where('achievement_id', $achievement->id)->exists()) {
                    $this->award($user, $achievement);
                    return $achievement;
                }
            }
        }

        return null;
    }

    public function checkReportMilestones(User $user): ?Achievement
    {
        $count = DailyReport::where('user_id', $user->id)->count();

        $milestones = [
            'first_report' => 1,
            '7_reports' => 7,
            '30_reports' => 30,
        ];

        foreach ($milestones as $key => $threshold) {
            if ($count >= $threshold) {
                $achievement = Achievement::where('key', $key)->first();
                if ($achievement && !$user->achievements()->where('achievement_id', $achievement->id)->exists()) {
                    $this->award($user, $achievement);
                    return $achievement;
                }
            }
        }

        return null;
    }

    public function checkCallMilestones(User $user): ?Achievement
    {
        $count = $user->calls()->where('status', 'completed')->count();

        $milestones = [
            'first_call' => 1,
            '10_calls' => 10,
            '100_calls' => 100,
        ];

        foreach ($milestones as $key => $threshold) {
            if ($count >= $threshold) {
                $achievement = Achievement::where('key', $key)->first();
                if ($achievement && !$user->achievements()->where('achievement_id', $achievement->id)->exists()) {
                    $this->award($user, $achievement);
                    return $achievement;
                }
            }
        }

        return null;
    }

    public function checkStreakMilestones(User $user): ?Achievement
    {
        $streak = $this->calculateStreak($user);

        $milestones = [
            '3_day_streak' => 3,
            '7_day_streak' => 7,
            '30_day_streak' => 30,
            '90_day_streak' => 90,
            '365_day_streak' => 365,
        ];

        foreach ($milestones as $key => $threshold) {
            if ($streak >= $threshold) {
                $achievement = Achievement::where('key', $key)->first();
                if ($achievement && !$user->achievements()->where('achievement_id', $achievement->id)->exists()) {
                    $this->award($user, $achievement);
                    return $achievement;
                }
            }
        }

        return null;
    }

    public function checkCompletionMilestones(User $user): ?Achievement
    {
        $today = now()->setTimezone($user->timezone)->toDateString();

        $dailyReports = DailyReport::where('user_id', $user->id)
            ->where('report_date', $today)
            ->first();

        if ($dailyReports && $dailyReports->completed_tasks > 0 && $dailyReports->pending_tasks === 0 && $dailyReports->discarded_tasks === 0) {
            $achievement = Achievement::where('key', 'perfect_day')->first();
            if ($achievement && !$user->achievements()->where('achievement_id', $achievement->id)->exists()) {
                $this->award($user, $achievement);
                return $achievement;
            }
        }

        $weekReports = DailyReport::where('user_id', $user->id)
            ->whereBetween('report_date', [now()->subDays(7)->toDateString(), $today])
            ->get();

        if ($weekReports->count() >= 7 && $weekReports->sum('pending_tasks') === 0) {
            $achievement = Achievement::where('key', 'perfect_week')->first();
            if ($achievement && !$user->achievements()->where('achievement_id', $achievement->id)->exists()) {
                $this->award($user, $achievement);
                return $achievement;
            }
        }

        return null;
    }

    public function calculateStreak(User $user): int
    {
        $tz = $user->timezone;
        $streak = 0;
        $date = now()->setTimezone($tz);

        for ($i = 0; $i < 365; $i++) {
            $dateStr = $date->copy()->subDays($i)->toDateString();

            $hasActivity = DailyReport::where('user_id', $user->id)
                ->where('report_date', $dateStr)
                ->where('completed_tasks', '>', 0)
                ->exists();

            if ($hasActivity) {
                $streak++;
            } elseif ($i > 0) {
                break;
            }
        }

        return $streak;
    }

    public function award(User $user, Achievement $achievement): void
    {
        DB::table('user_achievements')->updateOrInsert(
            ['user_id' => $user->id, 'achievement_id' => $achievement->id],
            ['earned_at' => now(), 'created_at' => now(), 'updated_at' => now()]
        );
    }

    public function getRecentAchievements(User $user, int $limit = 5)
    {
        return $user->achievements()
            ->withPivot('earned_at')
            ->orderByPivot('earned_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getEarnedAchievementKeys(User $user): array
    {
        return $user->achievements()->pluck('achievements.key')->toArray();
    }
}
