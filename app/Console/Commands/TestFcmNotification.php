<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\FcmNotificationService;
use Illuminate\Console\Command;

class TestFcmNotification extends Command
{
    protected $signature = 'test:fcm
        {user : User ID or email address}
        {--title=Test Notification : Notification title}
        {--body=This is a test push from dialer.best : Notification body}
        {--call : Simulate an incoming call notification}';

    protected $description = 'Send a test FCM push notification to a user';

    public function handle(FcmNotificationService $fcm)
    {
        $identifier = $this->argument('user');

        $user = is_numeric($identifier)
            ? User::find((int) $identifier)
            : User::where('email', $identifier)->first();

        if (!$user) {
            $this->error("User not found: $identifier");
            return 1;
        }

        if (!$user->fcm_token) {
            $this->error("User {$user->name} has no FCM token registered.");
            $this->line('Have them log into the mobile app first to register a token.');
            return 1;
        }

        if ($this->option('call')) {
            $success = $fcm->sendIncomingCall(
                $user->id,
                callId: 'test-call-' . time(),
                callerName: 'dialer.best',
                callType: 'Test'
            );
            $label = 'incoming call notification';
        } else {
            $success = $fcm->send(
                $user->id,
                title: $this->option('title'),
                body: $this->option('body'),
                data: ['type' => 'test', 'source' => 'cli']
            );
            $label = 'notification';
        }

        if ($success) {
            $this->info("✅ FCM $label sent to {$user->name} ({$user->email})");
        } else {
            $this->error("❌ Failed to send FCM $label. Check storage/logs/laravel.log for details.");
            return 1;
        }

        $this->line("   Token: {$user->fcm_token}");
    }
}
