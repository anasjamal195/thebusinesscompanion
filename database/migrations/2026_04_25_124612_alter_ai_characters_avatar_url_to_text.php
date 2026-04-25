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
        if (!Schema::hasTable('ai_characters') || !Schema::hasColumn('ai_characters', 'avatar_url')) {
            return;
        }

        Schema::table('ai_characters', function (Blueprint $table) {
            $table->text('avatar_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('ai_characters') || !Schema::hasColumn('ai_characters', 'avatar_url')) {
            return;
        }

        Schema::table('ai_characters', function (Blueprint $table) {
            $table->string('avatar_url')->nullable()->change();
        });
    }
};
