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
            if (Schema::hasColumn('card_orders', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
        });

        Schema::table('certificate_orders', function (Blueprint $table) {
            if (Schema::hasColumn('certificate_orders', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
        });

        Schema::table('credit_applications', function (Blueprint $table) {
            if (Schema::hasColumn('credit_applications', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_orders', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
        });

        Schema::table('certificate_orders', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
        });

        Schema::table('credit_applications', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
        });
    }
};
