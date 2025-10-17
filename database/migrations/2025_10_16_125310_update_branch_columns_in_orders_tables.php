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
        // CARD ORDERS
        Schema::table('card_orders', function (Blueprint $table) {
            $table->dropColumn('bank_branch');
            $table->unsignedBigInteger('bank_branch_id')->after('id');
            $table->foreign('bank_branch_id')->references('id')->on('locations')->onDelete('set null');
        });
        // CERTIFICATE ORDERS
        Schema::table('certificate_orders', function (Blueprint $table) {
            $table->dropColumn('bank_branch');
            $table->unsignedBigInteger('bank_branch_id')->after('id');
            $table->foreign('bank_branch_id')->references('id')->on('locations')->onDelete('set null');
        });

        // CREDIT APPLICATIONS
        Schema::table('credit_applications', function (Blueprint $table) {
            $table->dropColumn('bank_name');
            $table->unsignedBigInteger('bank_branch_id')->nullable()->after('id');
            $table->foreign('bank_branch_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_orders', function (Blueprint $table) {
            $table->dropForeign(['bank_branch_id']);
            $table->dropColumn('bank_branch_id');
            $table->string('bank_branch')->nullable();
        });

        Schema::table('certificate_orders', function (Blueprint $table) {
            $table->dropForeign(['bank_branch_id']);
            $table->dropColumn('bank_branch_id');
            $table->string('bank_branch')->nullable();
        });

        Schema::table('credit_applications', function (Blueprint $table) {
            $table->dropForeign(['bank_branch_id']);
            $table->dropColumn('bank_branch_id');
            $table->string('bank_name')->nullable();
        });
    }
};
