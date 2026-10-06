<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var list<string>
     */
    private array $tables = [
        'deposit_types',
        'money_transfers',
        'tariff_categories',
        'tariff_details',
        'exchange_rates',
        'news',
        'awards',
        'clients',
        'audit_reports',
        'locations',
    ];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            if (! Schema::hasColumn($tableName, 'is_active')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->boolean('is_active')->default(true);
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasColumn($tableName, 'is_active')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('is_active');
                });
            }
        }
    }
};
