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
        Schema::create('ai_characters', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // stable identifier stored on users.character_type
            $table->string('occupation'); // e.g. Founder, Engineer
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->text('bio')->nullable();
            $table->longText('system_prompt');
            $table->string('avatar_url')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['occupation', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_characters');
    }
};
