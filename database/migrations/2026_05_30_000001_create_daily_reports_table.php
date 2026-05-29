<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('daily_reports')) {
            Schema::create('daily_reports', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->date('report_date');
                $table->text('summary')->nullable();
                $table->json('tasks_data')->nullable();
                $table->integer('total_tasks')->default(0);
                $table->integer('completed_tasks')->default(0);
                $table->integer('pending_tasks')->default(0);
                $table->integer('discarded_tasks')->default(0);
                $table->timestamps();

                $table->unique(['user_id', 'report_date']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
