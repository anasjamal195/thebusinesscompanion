<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ai_characters', function (Blueprint $table) {
            $table->decimal('monthly_price', 8, 2)->default(4.99);
            $table->boolean('is_premium')->default(true);
            $table->string('stripe_price_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_characters', function (Blueprint $table) {
            $table->dropColumn(['monthly_price', 'is_premium', 'stripe_price_id']);
        });
    }
};
