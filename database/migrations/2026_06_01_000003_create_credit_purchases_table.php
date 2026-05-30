<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2)->comment('USD amount paid');
            $table->decimal('credits_added', 10, 2)->comment('Credits added (1:1 with USD)');
            $table->string('stripe_session_id')->nullable()->index();
            $table->string('status')->default('pending')->comment('pending, completed, failed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_purchases');
    }
};
