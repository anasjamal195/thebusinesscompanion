<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('vapi_voice_id')->unique();
            $table->string('provider')->default('11labs');
            $table->string('gender')->nullable();
            $table->string('accent')->nullable();
            $table->text('description')->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('sample_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voices');
    }
};