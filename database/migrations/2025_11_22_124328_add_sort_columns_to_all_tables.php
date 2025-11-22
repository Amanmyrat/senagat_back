<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'locations',
            'news',
            'card_types',
            'credit_types',
            'certificate_types',
            'exchange_rates',
            'deposit_types',
            'tariff_categories',
            'tariff_details',
            'clients',
            'awards',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {

                if (!Schema::hasColumn($tableName, 'sort')) {
                    $table->integer('sort')->nullable();
                }
                 if ($tableName === 'tariff_categories') {
                    if (!Schema::hasColumn('tariff_categories', 'numbers')) {
                        $table->string('numbers')->nullable();
                    }
                }
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'locations',
            'news',
            'card_types',
            'credit_types',
            'certificate_types',
            'exchange_rates',
            'deposit_types',
            'tariff_categories',
            'tariff_details',
            'clients',
            'awards',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {

                if (Schema::hasColumn($tableName, 'sort')) {
                    $table->dropColumn('sort');
                }

                if ($tableName === 'tariff_categories') {
                    if (Schema::hasColumn('tariff_categories', 'numbers')) {
                        $table->dropColumn('numbers');
                    }
                }

            });
        }
    }
};
