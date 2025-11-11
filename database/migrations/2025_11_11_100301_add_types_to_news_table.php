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
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->text('title')->after('id');
            $table->json('types')->nullable()->after('description');
            $table->string('image_url')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['title', 'image_url', 'types']);
            $table->string('title')->after('id');
            $table->text('description')->after('title');
        });
    }
};
