<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\VapiService;
use Illuminate\Console\Command;

class TestVapiCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:vapi-call {user_id} {--phone=} {--voice_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger a test Vapi call for a user';

    /**
     * Execute the console command.
     */
    public function handle(VapiService $vapiService)
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error("User not found!");
            return;
        }

        if ($this->option('phone')) {
            $user->profile()->updateOrCreate(['user_id' => $user->id], ['phone_number' => $this->option('phone')]);
            $this->info("Updated phone number to: " . $this->option('phone'));
        }

        if ($this->option('voice_id')) {
            $user->update(['voice_id' => $this->option('voice_id')]);
            $this->info("Updated voice_id to: " . $this->option('voice_id'));
        }

        if (!$user->voice_id) {
            $this->error("User has no voice_id. Use --voice_id=X");
            return;
        }

        if (!$user->profile || !$user->profile->phone_number) {
            $this->error("User has no phone number. Use --phone=+123456789");
            return;
        }

        $this->info("Initiating call for {$user->name} to {$user->profile->phone_number}...");
        
        $result = $vapiService->createCall($user);

        if ($result) {
            $this->info("Call initiated successfully! Call ID: " . $result['id']);
        } else {
            $this->error("Failed to initiate call. Check logs.");
        }
    }
}
