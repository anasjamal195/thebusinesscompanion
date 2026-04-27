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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('companion_id')->nullable()->constrained('ai_characters');
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
            $table->json('availability_hours')->nullable();
            $table->integer('max_call_duration')->nullable();
            $table->integer('daily_calling_limit')->nullable();
            $table->string('business_url')->nullable();
            $table->text('business_description')->nullable();
            $table->text('current_problems')->nullable();
            $table->text('urgent_tasks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['companion_id']);
            $table->dropColumn('companion_id');
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'phone_number',
                'availability_hours',
                'max_call_duration',
                'daily_calling_limit',
                'business_url',
                'business_description',
                'current_problems',
                'urgent_tasks',
            ]);
        });
    }
};
