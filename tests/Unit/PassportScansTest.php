<?php

namespace Tests\Unit;

use App\Casts\PassportScansCast;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

class PassportScansTest extends TestCase
{
    public function test_legacy_single_path_is_read_as_one_file(): void
    {
        $this->assertSame(
            ['scans/passport.pdf'],
            UserProfile::normalizePassportPaths('scans/passport.pdf')
        );
    }

    public function test_json_list_and_array_keep_every_path(): void
    {
        $paths = ['scans/page-1.jpg', 'scans/page-2.jpg', 'scans/page-3.pdf'];

        $this->assertSame($paths, UserProfile::normalizePassportPaths($paths));
        $this->assertSame($paths, UserProfile::normalizePassportPaths(json_encode($paths)));
    }

    public function test_empty_values_become_an_empty_list(): void
    {
        $this->assertSame([], UserProfile::normalizePassportPaths(null));
        $this->assertSame([], UserProfile::normalizePassportPaths(''));
        $this->assertSame([], UserProfile::normalizePassportPaths(['', null]));
    }

    public function test_cast_reads_a_legacy_string_and_stores_at_most_four_files(): void
    {
        $cast = new PassportScansCast;
        $model = $this->createMock(Model::class);

        $this->assertSame(
            ['scans/a.pdf'],
            $cast->get($model, 'scan_passport', 'scans/a.pdf', [])
        );

        $stored = $cast->set($model, 'scan_passport', [
            'scans/1.jpg',
            'scans/2.jpg',
            'scans/3.jpg',
            'scans/4.jpg',
            'scans/5.jpg',
        ], []);

        $this->assertSame([
            'scans/1.jpg',
            'scans/2.jpg',
            'scans/3.jpg',
            'scans/4.jpg',
        ], json_decode($stored, true));
    }
}
