<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('card_orders', function (Blueprint $table) {
            //Remove home_phone_number and status
            if (Schema::hasColumn('card_orders', 'home_phone_number')) {
                $table->dropColumn('home_phone_number');
            }
            if (Schema::hasColumn('card_orders', 'status')) {
                $table->dropColumn('status');
            }
            // New Columns
            $table->text('current_address')->nullable();
            $table->string('work_position')->nullable();
            $table->integer('work_phone')->nullable();
            $table->boolean('internet_service')->default(false);
            $table->boolean('delivery')->default(false);
            $table->string('email')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('status')->default('draft');
            $table->index(['status', 'created_at'], 'card_orders_status_created_at_index');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS card_orders_status_created_at_index');

        Schema::table('card_orders', function (Blueprint $table) {
            $table->string('home_phone_number')->nullable();
            $table->dropColumn([
                'current_address',
                'work_position',
                'work_phone',
                'internet_service',
                'delivery',
                'email',
                'expires_at',
                'status',
            ]);

        });

        DB::statement("
            ALTER TABLE card_orders
            ADD COLUMN status VARCHAR(20) DEFAULT 'pending'
            CHECK (status IN ('approved', 'pending', 'rejected'))
        ");
    }
};
