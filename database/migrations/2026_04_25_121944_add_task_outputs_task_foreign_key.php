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
        if (!Schema::hasTable('task_outputs') || !Schema::hasTable('tasks')) {
            return;
        }

        Schema::table('task_outputs', function (Blueprint $table) {
            try {
                $table->foreign('task_id')->references('id')->on('tasks')->cascadeOnDelete();
            } catch (\Throwable) {
                // Ignore.
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('task_outputs')) {
            return;
        }

        Schema::table('task_outputs', function (Blueprint $table) {
            try {
                $table->dropForeign(['task_id']);
            } catch (\Throwable) {
                // Ignore.
            }
        });
    }
};
