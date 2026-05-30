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
        Schema::table('certificate_orders', function (Blueprint $table) {
            $table->boolean('wants_payment')
                ->default(false)
                ->after('status');
        });

        Schema::table('card_orders', function (Blueprint $table) {
            $table->boolean('wants_payment')
                ->default(false)
                ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificate_orders', function (Blueprint $table) {
            $table->dropColumn('wants_payment');

        });
        Schema::table('card_orders', function (Blueprint $table) {
            $table->dropColumn('wants_payment');
        });
    }
};
