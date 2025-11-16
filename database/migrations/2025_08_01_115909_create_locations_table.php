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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->json('name');
            $table->json('address');
            $table->json('location');
            $table->string('phone_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('home_number')->nullable();
            $table->json('hours')->nullable();
            $table->boolean('branch_services')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
