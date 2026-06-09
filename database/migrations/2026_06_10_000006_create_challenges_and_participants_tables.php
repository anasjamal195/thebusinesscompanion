<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('slug')->unique();
            $table->string('icon')->default('flag');
            $table->date('start_date');
            $table->date('end_date');
            $table->json('requirements')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('challenge_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('progress_data')->nullable();
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['challenge_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_participants');
        Schema::dropIfExists('challenges');
    }
};
