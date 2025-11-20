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
        Schema::table('tariff_details', function (Blueprint $table) {
            if (Schema::hasColumn('tariff_details', 'number')) {
                $table->dropColumn('number');
            }
        });

        Schema::table('tariff_details', function (Blueprint $table) {
            $table->string('number')->nullable();
            $table->string('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tariff_details', function (Blueprint $table) {
            if (Schema::hasColumn('tariff_details', 'number')) {
                $table->dropColumn('number');
            }

            if (Schema::hasColumn('tariff_details', 'title')) {
                $table->dropColumn('title');
            }
        });

        Schema::table('tariff_details', function (Blueprint $table) {
            $table->string('number')->nullable();
        });
    }

};
