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
        if (!Schema::hasTable('conversation_messages') || !Schema::hasTable('conversations')) {
            return;
        }

        Schema::table('conversation_messages', function (Blueprint $table) {
            try {
                $table->foreign('conversation_id')->references('id')->on('conversations')->cascadeOnDelete();
            } catch (\Throwable) {
                // Ignore if already exists.
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('conversation_messages')) {
            return;
        }

        Schema::table('conversation_messages', function (Blueprint $table) {
            try {
                $table->dropForeign(['conversation_id']);
            } catch (\Throwable) {
                // Ignore.
            }
        });
    }
};
