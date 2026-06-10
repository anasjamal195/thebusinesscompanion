<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('community_posts', function (Blueprint $table) {
            $table->string('visibility')->default('public')->after('is_pinned');
            $table->json('hidden_tasks')->nullable()->after('visibility');
            $table->unsignedBigInteger('daily_report_id')->nullable()->after('hidden_tasks');
        });
    }

    public function down(): void
    {
        Schema::table('community_posts', function (Blueprint $table) {
            $table->dropColumn(['visibility', 'hidden_tasks', 'daily_report_id']);
        });
    }
};
