<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            // Task Milestones
            ['key' => 'first_task', 'name' => 'First Steps', 'description' => 'Complete your first task', 'icon' => 'check_circle', 'category' => 'tasks', 'threshold' => 1, 'badge_color' => '#00AFF0', 'sort_order' => 1],
            ['key' => '10_tasks', 'name' => 'Getting Productive', 'description' => 'Complete 10 tasks', 'icon' => 'task_alt', 'category' => 'tasks', 'threshold' => 10, 'badge_color' => '#6366f1', 'sort_order' => 2],
            ['key' => '100_tasks', 'name' => 'Task Master', 'description' => 'Complete 100 tasks', 'icon' => 'stars', 'category' => 'tasks', 'threshold' => 100, 'badge_color' => '#f59e0b', 'sort_order' => 3],
            ['key' => '1000_tasks', 'name' => 'Legendary Productivity', 'description' => 'Complete 1,000 tasks', 'icon' => 'diamond', 'category' => 'tasks', 'threshold' => 1000, 'badge_color' => '#8b5cf6', 'sort_order' => 4],

            // Report Milestones
            ['key' => 'first_report', 'name' => 'First Review', 'description' => 'Generate your first daily report', 'icon' => 'summarize', 'category' => 'reports', 'threshold' => 1, 'badge_color' => '#00AFF0', 'sort_order' => 5],
            ['key' => '7_reports', 'name' => 'Weekly Tracker', 'description' => 'Generate 7 daily reports', 'icon' => 'calendar_view_week', 'category' => 'reports', 'threshold' => 7, 'badge_color' => '#6366f1', 'sort_order' => 6],
            ['key' => '30_reports', 'name' => 'Monthly Analyst', 'description' => 'Generate 30 daily reports', 'icon' => 'calendar_month', 'category' => 'reports', 'threshold' => 30, 'badge_color' => '#f59e0b', 'sort_order' => 7],

            // Accountability Milestones
            ['key' => 'first_call', 'name' => 'First Check-In', 'description' => 'Answer your first AI call', 'icon' => 'phone_in_talk', 'category' => 'accountability', 'threshold' => 1, 'badge_color' => '#00AFF0', 'sort_order' => 8],
            ['key' => '10_calls', 'name' => 'Committed', 'description' => 'Answer 10 AI calls', 'icon' => 'phone_forwarded', 'category' => 'accountability', 'threshold' => 10, 'badge_color' => '#6366f1', 'sort_order' => 9],
            ['key' => '100_calls', 'name' => 'Unstoppable', 'description' => 'Answer 100 AI calls', 'icon' => 'phone_android', 'category' => 'accountability', 'threshold' => 100, 'badge_color' => '#f59e0b', 'sort_order' => 10],

            // Consistency Milestones
            ['key' => '3_day_streak', 'name' => 'Getting Started', 'description' => 'Maintain a 3-day streak', 'icon' => 'local_fire_department', 'category' => 'consistency', 'threshold' => 3, 'badge_color' => '#f97316', 'sort_order' => 11],
            ['key' => '7_day_streak', 'name' => 'One Week Strong', 'description' => 'Maintain a 7-day streak', 'icon' => 'whatshot', 'category' => 'consistency', 'threshold' => 7, 'badge_color' => '#ef4444', 'sort_order' => 12],
            ['key' => '30_day_streak', 'name' => 'Monthly Warrior', 'description' => 'Maintain a 30-day streak', 'icon' => 'fireplace', 'category' => 'consistency', 'threshold' => 30, 'badge_color' => '#dc2626', 'sort_order' => 13],
            ['key' => '90_day_streak', 'name' => 'Quarterly Champion', 'description' => 'Maintain a 90-day streak', 'icon' => 'military_tech', 'category' => 'consistency', 'threshold' => 90, 'badge_color' => '#991b1b', 'sort_order' => 14],
            ['key' => '365_day_streak', 'name' => 'Year of Excellence', 'description' => 'Maintain a 365-day streak', 'icon' => 'emoji_events', 'category' => 'consistency', 'threshold' => 365, 'badge_color' => '#f59e0b', 'sort_order' => 15],

            // Completion Milestones
            ['key' => 'perfect_day', 'name' => 'Perfect Day', 'description' => 'Complete all tasks in a single day', 'icon' => 'checklist', 'category' => 'completion', 'threshold' => 1, 'badge_color' => '#10b981', 'sort_order' => 16],
            ['key' => 'perfect_week', 'name' => 'Perfect Week', 'description' => 'Complete all tasks for a full week', 'icon' => 'verified', 'category' => 'completion', 'threshold' => 7, 'badge_color' => '#059669', 'sort_order' => 17],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['key' => $achievement['key']],
                $achievement
            );
        }
    }
}
