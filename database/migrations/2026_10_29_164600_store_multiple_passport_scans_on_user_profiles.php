<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Widen scan_passport and store every existing file as a JSON list.
     * A plain path stays readable until this runs, and a one-file upload still works after it.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE user_profiles ALTER COLUMN scan_passport TYPE text');
        } elseif ($driver === 'mysql') {
            DB::statement('ALTER TABLE user_profiles MODIFY scan_passport TEXT NOT NULL');
        }

        DB::table('user_profiles')->orderBy('id')->chunkById(200, function ($rows): void {
            foreach ($rows as $row) {
                $current = $row->scan_passport;

                if (! is_string($current) || $current === '') {
                    continue;
                }

                $decoded = json_decode($current, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    continue;
                }

                DB::table('user_profiles')->where('id', $row->id)->update([
                    'scan_passport' => json_encode([$current]),
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('user_profiles')->orderBy('id')->chunkById(200, function ($rows): void {
            foreach ($rows as $row) {
                $decoded = json_decode((string) $row->scan_passport, true);
                if (! is_array($decoded)) {
                    continue;
                }

                DB::table('user_profiles')->where('id', $row->id)->update([
                    'scan_passport' => (string) ($decoded[0] ?? ''),
                ]);
            }
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE user_profiles ALTER COLUMN scan_passport TYPE varchar(255)');
        } elseif ($driver === 'mysql') {
            DB::statement('ALTER TABLE user_profiles MODIFY scan_passport VARCHAR(255) NOT NULL');
        }
    }
};
