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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->string('call_id')->unique(); // Retell Call ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ai_character_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('initiated');
            $table->enum('direction', ['inbound', 'outbound'])->default('outbound');
            $table->text('transcript')->nullable();
            $table->string('recording_url')->nullable();
            $table->json('metadata')->nullable();
            $table->integer('duration')->nullable(); // In seconds
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
