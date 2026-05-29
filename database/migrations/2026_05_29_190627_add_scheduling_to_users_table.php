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
        Schema::table('users', function (Blueprint $table) {
            $table->time('morning_call_time')->nullable();
            $table->string('timezone')->default('UTC');
            $table->integer('default_delay_minutes')->nullable();
            $table->date('last_morning_call_date')->nullable();
            $table->datetime('last_call_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['morning_call_time', 'timezone', 'default_delay_minutes', 'last_morning_call_date', 'last_call_time']);
        });
    }
};
