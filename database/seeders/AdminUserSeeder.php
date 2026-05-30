<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admink2@dialer.best'],
            [
                'name' => 'Admin',
                'email' => 'admink2@dialer.best',
                'password' => Hash::make('K#9mP$2vL@8xQ!nB7wE*5rT'),
                'role' => 'admin',
                'credits' => 999999.99,
                'onboarding_completed' => true,
            ]
        );

        $this->command->info('Admin user seeded: admink2@dialer.best');
    }
}
