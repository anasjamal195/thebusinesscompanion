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
        if (!Schema::hasTable('reports')) {
            Schema::create('reports', function (Blueprint $table) {
                $table->id();
                $table->foreignId('task_id')->constrained()->cascadeOnDelete();
                $table->text('summary')->nullable();
                $table->text('insights')->nullable();
                $table->text('recommendations')->nullable();
                $table->timestamps();

                $table->unique('task_id');
            });
            return;
        }

        Schema::table('reports', function (Blueprint $table) {
            if (!Schema::hasColumn('reports', 'task_id')) {
                $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('reports', 'summary')) {
                $table->text('summary')->nullable();
            }
            if (!Schema::hasColumn('reports', 'insights')) {
                $table->text('insights')->nullable();
            }
            if (!Schema::hasColumn('reports', 'recommendations')) {
                $table->text('recommendations')->nullable();
            }

            // If the table already existed, we avoid adding indexes here to prevent duplicate-key issues.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
