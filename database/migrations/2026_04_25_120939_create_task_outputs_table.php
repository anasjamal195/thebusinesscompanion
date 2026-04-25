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
        if (Schema::hasTable('task_outputs')) {
            return;
        }

        Schema::create('task_outputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id');
            $table->longText('output_text');
            $table->json('structured_data')->nullable();
            $table->timestamps();

            $table->unique('task_id');
            $table->index('task_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_outputs');
    }
};
