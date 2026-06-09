<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('community_participation_mode')->default('private')->after('fcm_token');
            $table->integer('execution_score')->default(0)->after('community_participation_mode');
            $table->integer('community_reputation')->default(0)->after('execution_score');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['community_participation_mode', 'execution_score', 'community_reputation']);
        });
    }
};
