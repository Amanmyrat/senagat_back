<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('credit_types', function (Blueprint $table) {


            if (Schema::hasColumn('credit_types', 'term')) {
                $table->dropColumn('term');
            }
            if (Schema::hasColumn('credit_types', 'min_amount')) {
                $table->dropColumn('min_amount');
            }
            if (Schema::hasColumn('credit_types', 'max_amount')) {
                $table->dropColumn('max_amount');
            }

            $table->boolean('can_offer_online')->default(false);


            $table->string('term_text')->nullable();
            $table->string('amount_text')->nullable();

            $table->unsignedInteger('term')->nullable();
            $table->unsignedInteger('min_amount')->nullable();
            $table->unsignedInteger('max_amount')->nullable();
        });
    }


    public function down(): void
    {
        Schema::table('credit_types', function (Blueprint $table) {


            $table->dropColumn([
                'can_offer_online',
                'term_text',
                'amount_text',
                'term',
                'min_amount',
                'max_amount',
            ]);


            $table->unsignedInteger('term');
            $table->unsignedInteger('min_amount');
            $table->unsignedInteger('max_amount');
        });
    }
};
