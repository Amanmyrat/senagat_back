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
        Schema::dropIfExists('card_category_card_type');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::create('card_category_card_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('card_type_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }
};
