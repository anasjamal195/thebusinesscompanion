<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Call;
use App\Models\Challenge;
use App\Models\ChallengeParticipant;
use App\Models\CommunityComment;
use App\Models\CommunityLike;
use App\Models\CommunityPost;
use App\Models\DailyReport;
use App\Models\Follow;
use App\Models\Mentor;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\AchievementService;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $achievementService = app(AchievementService::class);

        // ── Users ─────────────────────────────────────────────────────────────
        $users = [];

        $userData = [
            ['name' => 'Alex Johnson', 'email' => 'alex@demo.com', 'execution_score' => 94, 'community_reputation' => 88, 'community_participation_mode' => 'social', 'credits' => 50],
            ['name' => 'Sarah Chen', 'email' => 'sarah@demo.com', 'execution_score' => 97, 'community_reputation' => 92, 'community_participation_mode' => 'social', 'credits' => 75],
            ['name' => 'Marcus Williams', 'email' => 'marcus@demo.com', 'execution_score' => 72, 'community_reputation' => 65, 'community_participation_mode' => 'hybrid', 'credits' => 30],
            ['name' => 'Emily Rodriguez', 'email' => 'emily@demo.com', 'execution_score' => 88, 'community_reputation' => 45, 'community_participation_mode' => 'social', 'credits' => 20],
            ['name' => 'David Kim', 'email' => 'david@demo.com', 'execution_score' => 61, 'community_reputation' => 35, 'community_participation_mode' => 'hybrid', 'credits' => 15],
            ['name' => 'Priya Patel', 'email' => 'priya@demo.com', 'execution_score' => 85, 'community_reputation' => 78, 'community_participation_mode' => 'social', 'credits' => 40],
            ['name' => 'James O\'Brien', 'email' => 'james@demo.com', 'execution_score' => 45, 'community_reputation' => 30, 'community_participation_mode' => 'private', 'credits' => 10],
            ['name' => 'Lisa Thompson', 'email' => 'lisa@demo.com', 'execution_score' => 91, 'community_reputation' => 82, 'community_participation_mode' => 'social', 'credits' => 60],
            ['name' => 'Ryan Garcia', 'email' => 'ryan@demo.com', 'execution_score' => 55, 'community_reputation' => 50, 'community_participation_mode' => 'hybrid', 'credits' => 25],
            ['name' => 'Amanda Foster', 'email' => 'amanda@demo.com', 'execution_score' => 78, 'community_reputation' => 70, 'community_participation_mode' => 'social', 'credits' => 35],
        ];

        foreach ($userData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('password'),
                'onboarding_completed' => true,
                'morning_call_time' => '08:00:00',
                'timezone' => 'America/New_York',
                'community_participation_mode' => $data['community_participation_mode'],
                'execution_score' => $data['execution_score'],
                'community_reputation' => $data['community_reputation'],
                'credits' => $data['credits'],
            ]);

            UserProfile::create([
                'user_id' => $user->id,
                'business_name' => fake()->company(),
                'business_type' => fake()->randomElement(['Technology', 'Consulting', 'Health', 'Education', 'Finance', 'Creative']),
                'industry' => fake()->randomElement(['SaaS', 'E-commerce', 'Services', 'Manufacturing']),
            ]);

            $users[] = $user;
        }

        $this->command->info('Created ' . count($users) . ' demo users.');

        // ── Projects & Tasks ──────────────────────────────────────────────────

        for ($dayOffset = 14; $dayOffset >= 0; $dayOffset--) {
            $date = now()->subDays($dayOffset)->toDateString();

            foreach ($users as $user) {
                $project = Project::inRandomOrder()->first() ?? Project::create([
                    'user_id' => $user->id,
                    'name' => fake()->randomElement(['Main Project', 'Side Hustle', 'Daily Ops', 'Q2 Goals']),
                    'description' => fake()->sentence(),
                ]);

                $taskCount = rand(2, 5);
                for ($i = 0; $i < $taskCount; $i++) {
                    $status = $dayOffset === 0
                        ? fake()->randomElement(['pending', 'completed', 'completed', 'completed'])
                        : 'completed';

                    Task::create([
                        'project_id' => $project->id,
                        'user_id' => $user->id,
                        'title' => fake()->randomElement([
                            'Review quarterly projections',
                            'Draft proposal for client',
                            'Update team on progress',
                            'Research competitor analysis',
                            'Refactor API endpoints',
                            'Write documentation',
                            'Design new landing page',
                            'Optimize database queries',
                            'Prepare presentation deck',
                            'Follow up with leads',
                            'Review code pull requests',
                            'Plan sprint retrospective',
                            'Update marketing materials',
                            'Test new feature deployment',
                            'Schedule stakeholder meeting',
                        ]),
                        'input_text' => fake()->sentence(8),
                        'priority' => fake()->randomElement(['high', 'medium', 'low']),
                        'status' => $status,
                        'date' => $date,
                        'estimated_minutes' => fake()->randomElement([15, 30, 45, 60, 90, 120]),
                    ]);
                }
            }
        }

        $this->command->info('Created tasks for all demo users across 15 days.');

        // ── Daily Reports ─────────────────────────────────────────────────────

        foreach ($users as $user) {
            $streakDays = rand(3, 14);
            for ($i = $streakDays; $i >= 0; $i--) {
                $reportDate = now()->subDays($i)->toDateString();
                $tasksForDay = Task::where('user_id', $user->id)
                    ->whereDate('date', $reportDate)
                    ->get();

                if ($tasksForDay->isEmpty()) {
                    continue;
                }

                DailyReport::create([
                    'user_id' => $user->id,
                    'report_date' => $reportDate,
                    'summary' => fake()->randomElement([
                        'Solid day of progress. Most tasks completed on time.',
                        'Focused and productive. Key milestones achieved.',
                        'Good momentum today. Some tasks pushed to tomorrow.',
                        'Highly productive day. Exceeded expectations.',
                        'Steady progress across all projects.',
                    ]),
                    'tasks_data' => $tasksForDay->toArray(),
                    'total_tasks' => $tasksForDay->count(),
                    'completed_tasks' => $tasksForDay->where('status', 'completed')->count(),
                    'pending_tasks' => $tasksForDay->where('status', 'pending')->count(),
                    'discarded_tasks' => $tasksForDay->where('status', 'discarded')->count(),
                ]);
            }
        }

        $this->command->info('Created daily reports for all demo users.');

        // ── Calls ─────────────────────────────────────────────────────────────

        foreach ($users as $user) {
            $callCount = rand(3, 10);
            for ($i = 0; $i < $callCount; $i++) {
                Call::create([
                    'user_id' => $user->id,
                    'status' => 'completed',
                    'direction' => 'outbound',
                    'duration' => rand(120, 600),
                    'transcript' => fake()->paragraph(),
                    'metadata' => [
                        'call_type' => fake()->randomElement(['morning', 'followup']),
                    ],
                    'created_at' => now()->subDays(rand(0, 14)),
                ]);
            }
        }

        $this->command->info('Created call history for all demo users.');

        // ── Achievements ──────────────────────────────────────────────────────

        $achievementKeys = Achievement::pluck('key')->toArray();

        foreach ($users as $user) {
            $earnedCount = rand(3, min(12, count($achievementKeys)));
            $earnedKeys = array_slice($achievementKeys, 0, $earnedCount);

            foreach ($earnedKeys as $key) {
                $achievement = Achievement::where('key', $key)->first();
                if ($achievement) {
                    $achievementService->award($user, $achievement);
                }
            }
        }

        $this->command->info('Awarded achievements to demo users.');

        // ── Challenges ────────────────────────────────────────────────────────

        $challenges = [
            [
                'name' => 'No Procrastination Week',
                'description' => 'Complete every single task on your agenda for 7 consecutive days. No procrastination, no excuses. Every task must be marked complete before midnight.',
                'slug' => 'no-procrastination-week',
                'icon' => 'bolt',
                'start_date' => now()->subDays(2)->toDateString(),
                'end_date' => now()->addDays(5)->toDateString(),
                'requirements' => ['complete_all_tasks', '7_day_streak'],
            ],
            [
                'name' => '30 Day Execution Sprint',
                'description' => 'Maintain an execution score above 80 for 30 consecutive days. This challenge pushes you to be your most productive self through consistent daily action.',
                'slug' => '30-day-execution-sprint',
                'icon' => 'speed',
                'start_date' => now()->subDays(10)->toDateString(),
                'end_date' => now()->addDays(20)->toDateString(),
                'requirements' => ['execution_score_80', '30_day_commitment'],
            ],
            [
                'name' => 'Startup Builder Challenge',
                'description' => 'Complete at least 5 tasks every day focused on building your startup or side project. Perfect for founders and entrepreneurs.',
                'slug' => 'startup-builder-challenge',
                'icon' => 'rocket_launch',
                'start_date' => now()->subDays(5)->toDateString(),
                'end_date' => now()->addDays(9)->toDateString(),
                'requirements' => ['5_tasks_daily', 'project_focus'],
            ],
            [
                'name' => 'Deep Work Marathon',
                'description' => 'Log 4+ hours of deep focused work daily for 2 weeks. No distractions, no multitasking. Pure focused execution.',
                'slug' => 'deep-work-marathon',
                'icon' => 'psychology',
                'start_date' => now()->addDays(3)->toDateString(),
                'end_date' => now()->addDays(17)->toDateString(),
                'requirements' => ['4_hours_deep_work', '14_day_commitment'],
            ],
            [
                'name' => 'Morning Routine Mastery',
                'description' => 'Complete your morning planning call every day for 21 days and build the ultimate morning routine habit.',
                'slug' => 'morning-routine-mastery',
                'icon' => 'wb_sunny',
                'start_date' => now()->subDays(1)->toDateString(),
                'end_date' => now()->addDays(20)->toDateString(),
                'requirements' => ['morning_call_daily', '21_day_habit'],
            ],
            [
                'name' => 'Task Completion Champion',
                'description' => 'Achieve 100% task completion rate for 14 days straight. Every task done, nothing left behind.',
                'slug' => 'task-completion-champion',
                'icon' => 'checklist',
                'start_date' => now()->subDays(30)->toDateString(),
                'end_date' => now()->subDays(16)->toDateString(),
                'requirements' => ['100_percent_completion', '14_day_streak'],
            ],
        ];

        foreach ($challenges as $data) {
            Challenge::create($data);
        }

        $this->command->info('Created ' . count($challenges) . ' challenges.');

        // ── Challenge Participants ────────────────────────────────────────────

        $activeChallenges = Challenge::where('is_active', true)->get();
        foreach ($activeChallenges as $challenge) {
            $participantCount = rand(3, 7);
            $challengeUsers = collect($users)->shuffle()->take($participantCount);

            foreach ($challengeUsers as $user) {
                $completed = $challenge->end_date < now() ? fake()->boolean(70) : false;

                ChallengeParticipant::create([
                    'challenge_id' => $challenge->id,
                    'user_id' => $user->id,
                    'progress_data' => ['tasks_completed' => rand(5, 30)],
                    'joined_at' => $challenge->start_date->copy()->addDays(rand(0, 3)),
                    'completed_at' => $completed ? $challenge->end_date : null,
                ]);
            }
        }

        $this->command->info('Created challenge participants.');

        // ── Community Posts ───────────────────────────────────────────────────

        $postTemplates = [
            ['type' => 'achievement', 'content' => 'Just hit my 30-day streak! Consistency really is the key to getting things done. Feels amazing to have maintained this for a full month.'],
            ['type' => 'achievement', 'content' => 'Completed 100 tasks! When I started using Dialer.best, I could barely finish 3 tasks a day. Now it\'s become second nature.'],
            ['type' => 'progress', 'content' => 'Knocked out all 5 tasks today before lunch. The morning planning calls are a game changer for setting the tone of the day.'],
            ['type' => 'progress', 'content' => 'Perfect day today — every task done, morning call answered, and report generated. Feeling unstoppable.'],
            ['type' => 'success_story', 'content' => 'After 60 days of accountability calls, I finally launched my business. The daily check-ins kept me honest and on track when motivation was low. If you\'re on the fence about committing to this process, just do it.'],
            ['type' => 'success_story', 'content' => 'I used to procrastinate constantly. Three months with Dialer.best and I\'ve built habits that stick. The AI follow-up calls are surprisingly effective — it\'s like having a coach in your pocket.'],
            ['type' => 'progress', 'content' => 'Execution score hit 90 today! Been putting in the work and it\'s showing. The streak is at 21 days and climbing.'],
            ['type' => 'achievement', 'content' => 'Earned the Perfect Week badge! First time ever completing every single task for an entire week. Onward to Perfect Month!'],
            ['type' => 'progress', 'content' => '15 follow-up calls answered this week. The AI really pushes you to think about why you\'re not making progress, not just what you need to do.'],
            ['type' => 'success_story', 'content' => 'Started with 0 structure in my day. Now I have a morning routine, prioritized tasks, and end every day with a clear report of what I accomplished. This changed my relationship with productivity.'],
            ['type' => 'challenge_result', 'content' => 'Completed the No Procrastination Week challenge! 7 days, every task done. The momentum is incredible — going to keep this streak going.'],
            ['type' => 'challenge_result', 'content' => 'Finished the Startup Builder Challenge with 45 tasks completed over 9 days. My MVP is now in beta thanks to this focused sprint.'],
            ['type' => 'progress', 'content' => 'New personal record: completed all tasks before 3 PM. The morning call optimization really helped me prioritize better.'],
            ['type' => 'achievement', 'content' => 'Answered 50 AI calls. What started as awkward conversations is now a key part of my accountability system. The AI knows my projects better than I do sometimes!'],
            ['type' => 'success_story', 'content' => 'I was skeptical about AI accountability at first. But having someone (or something) check in on my progress made all the difference. 90 days in and I\'ve completed more than I did all last year.'],
        ];

        $postUsers = collect($users)->shuffle();
        $createdPosts = [];

        foreach ($postTemplates as $index => $template) {
            $user = $postUsers[$index % count($postUsers)];
            $achievement = null;

            if ($template['type'] === 'achievement') {
                $achievement = $user->achievements()->inRandomOrder()->first();
            }

            $post = CommunityPost::create([
                'user_id' => $user->id,
                'type' => $template['type'],
                'content' => $template['content'],
                'achievement_id' => $achievement?->id,
                'metadata' => $achievement ? [
                    'achievement_key' => $achievement->key,
                    'achievement_name' => $achievement->name,
                    'badge_color' => $achievement->badge_color,
                    'icon' => $achievement->icon,
                ] : null,
                'created_at' => now()->subHours(rand(1, 72)),
            ]);

            $createdPosts[] = $post;
        }

        $this->command->info('Created ' . count($createdPosts) . ' community posts.');

        // ── Comments ──────────────────────────────────────────────────────────

        $commentTemplates = [
            'That\'s amazing! Keep it up!',
            'Incredible progress. What was the biggest change you made?',
            'This is so inspiring! Thanks for sharing.',
            'Love seeing this. Consistency really is everything.',
            'How did you push through the tough days?',
            'You\'re on fire! What\'s your secret?',
            'This motivated me to get back on track. Thank you!',
            'Great work! The streak is impressive.',
            'I had a similar experience. The morning calls changed everything for me.',
            'Keep going! You\'re building something special.',
            'This is the kind of content that makes this community great.',
            'Respect for the dedication. Truly inspiring.',
        ];

        foreach ($createdPosts as $post) {
            $commentCount = rand(1, 4);
            $commentUsers = collect($users)->where('id', '!=', $post->user_id)->shuffle()->take($commentCount);

            foreach ($commentUsers as $commentUser) {
                CommunityComment::create([
                    'post_id' => $post->id,
                    'user_id' => $commentUser->id,
                    'content' => fake()->randomElement($commentTemplates),
                    'created_at' => $post->created_at->addHours(rand(1, 24)),
                ]);
            }
        }

        $this->command->info('Created comments on posts.');

        // ── Likes ─────────────────────────────────────────────────────────────

        foreach ($createdPosts as $post) {
            $likeCount = rand(2, 8);
            $likeUsers = collect($users)->where('id', '!=', $post->user_id)->shuffle()->take($likeCount);

            foreach ($likeUsers as $likeUser) {
                CommunityLike::firstOrCreate([
                    'post_id' => $post->id,
                    'user_id' => $likeUser->id,
                ]);
            }
        }

        $this->command->info('Created likes on posts.');

        // ── Follows ───────────────────────────────────────────────────────────

        foreach ($users as $user) {
            $followCount = rand(2, 6);
            $followUsers = collect($users)->where('id', '!=', $user->id)->shuffle()->take($followCount);

            foreach ($followUsers as $followUser) {
                Follow::firstOrCreate([
                    'follower_id' => $user->id,
                    'following_id' => $followUser->id,
                ]);
            }
        }

        $this->command->info('Created follow relationships.');

        // ── Mentors ───────────────────────────────────────────────────────────

        $mentorCandidates = collect($users)->filter(fn ($u) => $u->execution_score >= 85)->take(4);

        $mentorBios = [
            'Helped over 50 professionals build consistent productivity habits. Specializing in task management and deep work methodologies.',
            'Serial entrepreneur turned productivity coach. I\'ve learned the hard way what works and what doesn\'t when it comes to getting things done.',
            'Former procrastinator, now productivity enthusiast. I help people break through mental barriers and build systems that stick.',
            'Productivity systems designer with a focus on sustainable habits. I believe in progress over perfection.',
        ];

        $mentorSpecialties = [
            ['Task Management', 'Deep Work', 'Goal Setting'],
            ['Accountability', 'Productivity', 'Time Management'],
            ['Procrastination', 'Morning Routines', 'Work-Life Balance'],
            ['Project Planning', 'Goal Setting', 'Accountability'],
        ];

        foreach ($mentorCandidates as $index => $candidate) {
            Mentor::create([
                'user_id' => $candidate->id,
                'bio' => $mentorBios[$index] ?? 'Productivity mentor dedicated to helping others achieve their goals through accountability and consistent action.',
                'specialties' => $mentorSpecialties[$index] ?? ['Productivity', 'Accountability'],
                'is_active' => true,
                'mentees_count' => rand(5, 30),
            ]);
        }

        $this->command->info('Created ' . $mentorCandidates->count() . ' mentors.');

        // ── Update Reputation Scores ─────────────────────────────────────
        foreach ($users as $user) {
            app(\App\Services\CommunityReputationService::class)->recalculate($user);
        }

        $this->command->info('Demo data seeded successfully!');
    }
}
