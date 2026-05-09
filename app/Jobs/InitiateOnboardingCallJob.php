<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\VapiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InitiateOnboardingCallJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(VapiService $vapiService): void
    {
        \Illuminate\Support\Facades\Log::info("InitiateOnboardingCallJob: Processing for User {$this->userId}");
        $user = User::find($this->userId);
        if ($user) {
            $vapiService->createCall($user);
            \Illuminate\Support\Facades\Log::info("InitiateOnboardingCallJob: CreateCall called for User {$this->userId}");
        } else {
            \Illuminate\Support\Facades\Log::error("InitiateOnboardingCallJob: User {$this->userId} not found");
        }
    }
}
