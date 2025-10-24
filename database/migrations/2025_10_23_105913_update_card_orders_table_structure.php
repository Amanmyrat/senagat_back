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
        Schema::table('card_orders', function (Blueprint $table) {
            // Remove home_phone_number and status
            if (Schema::hasColumn('card_orders', 'home_phone_number')) {
                $table->dropColumn('home_phone_number');
            }

            // New Columns
            $table->string('work_position')->nullable();
            $table->integer('work_phone')->nullable();
            $table->boolean('internet_service')->default(false);
            $table->boolean('delivery')->default(false);
            $table->string('email')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_orders', function (Blueprint $table) {
            $table->string('home_phone_number')->nullable();

            $table->dropColumn([
                'work_position',
                'work_phone',
                'internet_service',
                'delivery',
                'email',
            ]);
        });
    }
};
