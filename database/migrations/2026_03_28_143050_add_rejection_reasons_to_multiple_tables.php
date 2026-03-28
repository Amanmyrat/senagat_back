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
        Schema::table('multiple_tables', function (Blueprint $table) {
            Schema::table('user_profiles', function (Blueprint $table) {
                $table->json('rejection_reasons')->nullable();
            });

            Schema::table('credit_applications', function (Blueprint $table) {
                $table->json('rejection_reasons')->nullable();
            });

            Schema::table('card_orders', function (Blueprint $table) {
                $table->json('rejection_reasons')->nullable();
            });

            Schema::table('certificate_orders', function (Blueprint $table) {
                $table->json('rejection_reasons')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('multiple_tables', function (Blueprint $table) {
            Schema::table('user_profiles', function (Blueprint $table) {
                $table->dropColumn('rejection_reasons');
            });

            Schema::table('credit_applications', function (Blueprint $table) {
                $table->dropColumn('rejection_reasons');
            });

            Schema::table('card_orders', function (Blueprint $table) {
                $table->dropColumn('rejection_reasons');
            });

            Schema::table('certificate_orders', function (Blueprint $table) {
                $table->dropColumn('rejection_reasons');
            });        });
    }
};
