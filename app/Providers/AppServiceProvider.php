<?php

namespace App\Providers;

use App\Listeners\AchievementListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\App\Services\AchievementService::class);
        $this->app->singleton(\App\Services\ExecutionScoreService::class);
        $this->app->singleton(\App\Services\CommunityReputationService::class);
    }

    public function boot(): void
    {
        Event::subscribe(AchievementListener::class);
    }
}
