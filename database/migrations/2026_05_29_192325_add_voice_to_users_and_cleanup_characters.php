<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Drop foreign keys if they exist, then columns
        Schema::table('users', function (Blueprint $table) {
            $table->string('voice_id')->default('jennifer')->after('role');
            
            // Drop foreign key and column if exists. We wrap in try-catch in case it was already dropped or name differs.
            try {
                $table->dropForeign(['companion_id']);
            } catch (\Exception $e) {}
            
            $table->dropColumn('companion_id');
        });

        Schema::table('calls', function (Blueprint $table) {
            try {
                $table->dropForeign(['ai_character_id']);
            } catch (\Exception $e) {}
            $table->dropColumn('ai_character_id');
        });

        // 2. Drop ai_characters table entirely
        Schema::dropIfExists('ai_characters');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We won't reconstruct the complex ai_characters table here for simplicity
        // in a real app you might want to.
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('voice_id');
            $table->unsignedBigInteger('companion_id')->nullable();
        });
        
        Schema::table('calls', function (Blueprint $table) {
            $table->unsignedBigInteger('ai_character_id')->nullable();
        });
    }
};
