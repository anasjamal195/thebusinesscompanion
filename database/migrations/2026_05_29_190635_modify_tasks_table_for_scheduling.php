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
        Schema::table('tasks', function (Blueprint $table) {
            $table->date('date')->nullable();
            $table->integer('estimated_minutes')->nullable();
            $table->datetime('scheduled_followup_time')->nullable();
            $table->unsignedBigInteger('project_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['date', 'estimated_minutes', 'scheduled_followup_time']);
            $table->unsignedBigInteger('project_id')->nullable(false)->change();
        });
    }
};
