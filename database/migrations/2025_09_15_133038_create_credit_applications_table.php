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
        Schema::create('credit_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('profile_id')->nullable()->constrained('user_profiles')->onDelete('cascade');
            $table->foreignId('credit_id')->nullable()->constrained('credit_types');
            $table->integer('years')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('interest', 5, 2)->nullable();
            $table->string('role')->nullable();
            // Entrepreneur
            $table->string('patent_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('work_address')->nullable();
            // Manager
            $table->string('workplace')->nullable();
            $table->string('position')->nullable();
            $table->string('manager_work_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->decimal('salary', 15, 2)->nullable();
            $table->string('country')->nullable();
            $table->string('bank_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_applications');
    }
};
