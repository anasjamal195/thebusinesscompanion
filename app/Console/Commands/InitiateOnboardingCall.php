<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\RetellService;
use Illuminate\Console\Command;

class InitiateOnboardingCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:onboard {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initiate an onboarding call for a specific user using Retell AI';

    /**
     * Execute the console command.
     */
    public function handle(RetellService $retellService)
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return 1;
        }

        if (!$user->profile || !$user->profile->phone_number) {
            $this->error("User {$user->name} (ID: {$userId}) does not have a phone number in their profile.");
            return 1;
        }

        $this->info("Initiating onboarding call for {$user->name}...");
        
        $result = $retellService->createCall($user);

        if ($result) {
            $this->info("Call successfully initiated!");
            $this->line("Call ID: " . ($result['call_id'] ?? 'N/A'));
            return 0;
        }

        $this->error("Failed to initiate call. Check logs for details.");
        return 1;
    }
}
