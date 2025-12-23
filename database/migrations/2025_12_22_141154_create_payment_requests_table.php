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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('type');
            $table->string('external_id')->nullable();
            $table->enum('status', [
                'sent',
                'pending',
                'notConfirmed',
                'confirming',
                'confirmed',
                'failed',
            ])->default('pending');
            $table->unsignedInteger('amount')->nullable();
            $table->json('payment_target')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->index(['type', 'external_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};
