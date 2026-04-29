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
        Schema::table('ai_characters', function (Blueprint $table) {
            $table->string('vapi_assistant_id')->nullable();
            $table->dropColumn(['retell_agent_id', 'retell_llm_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_characters', function (Blueprint $table) {
            $table->dropColumn('vapi_assistant_id');
            $table->string('retell_agent_id')->nullable();
            $table->string('retell_llm_id')->nullable();
        });
    }
};
