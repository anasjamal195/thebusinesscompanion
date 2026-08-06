<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@goalchaser.co');
        $password = env('ADMIN_PASSWORD', 'ChangeMe#2026!');

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'credits' => 999999.99,
                'onboarding_completed' => true,
            ]
        );

        $this->command->info("Admin user seeded: {$email}");
    }
}