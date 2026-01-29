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
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->dropColumn(['purchase', 'sale']);
        });

        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->decimal('purchase', 15, 4)->default(0)->after('currency');
            $table->decimal('sale', 15, 4)->default(0)->after('purchase');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->dropColumn(['purchase', 'sale']);
        });

        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->decimal('purchase', 10, 2)->after('currency')->nullable();
            $table->decimal('sale', 10, 2)->after('purchase')->nullable();
        });
    }
};
