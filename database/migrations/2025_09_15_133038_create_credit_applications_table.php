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
            $table->foreignId('profile_id')->constrained('user_profiles')->onDelete('cascade');
            $table->foreignId('credit_id')->constrained('credit_types');
            $table->integer('term');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('interest');
            $table->unsignedInteger('monthly_payment');

            // Entrepreneur
            $table->string('role')->nullable();
            $table->string('patent_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('work_address')->nullable();
            // Manager
            $table->string('workplace')->nullable();
            $table->string('position')->nullable();
            $table->string('manager_work_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->unsignedInteger('salary')->nullable();

            $table->string('country');
            $table->foreignId('bank_branch_id')->constrained('locations')->onDelete('cascade');
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');
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
