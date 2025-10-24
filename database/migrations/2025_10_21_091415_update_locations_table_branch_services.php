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
        Schema::table('locations', function (Blueprint $table) {
            if (Schema::hasColumn('locations', 'offers_credit')) {
                $table->dropColumn('offers_credit');
            }
            if (Schema::hasColumn('locations', 'offers_card')) {
                $table->dropColumn('offers_card');
            }
            if (Schema::hasColumn('locations', 'offers_certificate')) {
                $table->dropColumn('offers_certificate');
            }

            if (! Schema::hasColumn('locations', 'branch_services')) {
                $table->boolean('branch_services')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            if (Schema::hasColumn('locations', 'branch_services')) {
                $table->dropColumn('branch_services');
            }

            if (! Schema::hasColumn('locations', 'offers_credit')) {
                $table->boolean('offers_credit')->default(false);
            }
            if (! Schema::hasColumn('locations', 'offers_card')) {
                $table->boolean('offers_card')->default(false);
            }
            if (! Schema::hasColumn('locations', 'offers_certificate')) {
                $table->boolean('offers_certificate')->default(false);
            }
        });
    }
};
