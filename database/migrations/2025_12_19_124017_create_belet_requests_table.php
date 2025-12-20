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
        Schema::create('belet_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('type');
            $table->string('external_id')->nullable();
            $table->enum('status', [
                'sent',
                'notConfirmed',
                'confirming',
                'confirmed',
                'failed',
            ]);
            $table->timestamps();
            $table->index(['type', 'external_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('belet_requests');
    }
};
