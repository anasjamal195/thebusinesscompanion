<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monetization_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('per_minute_rate', 8, 2)->default(1.00)->comment('USD per minute charged to users');
            $table->decimal('minimum_refill', 8, 2)->default(5.00)->comment('Minimum credit refill in USD');
            $table->timestamps();
        });

        // Insert default singleton row
        DB::table('monetization_settings')->insert([
            'per_minute_rate' => 1.00,
            'minimum_refill' => 5.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('monetization_settings');
    }
};
