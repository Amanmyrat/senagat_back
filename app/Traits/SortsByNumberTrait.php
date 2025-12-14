<?php


namespace App\Traits;

use Illuminate\Support\Collection;

trait SortsByNumberTrait
{
    protected function sortByDottedNumber(Collection $items, string $key = 'number'): Collection
    {
        return $items->sort(function ($a, $b) use ($key) {
            $aParts = array_map('intval', explode('.', $a[$key] ?? '0'));
            $bParts = array_map('intval', explode('.', $b[$key] ?? '0'));

            $len = max(count($aParts), count($bParts));

            for ($i = 0; $i < $len; $i++) {
                $aVal = $aParts[$i] ?? 0;
                $bVal = $bParts[$i] ?? 0;

                if ($aVal !== $bVal) {
                    return $aVal <=> $bVal;
                }
            }

            return 0;
        })->values();
    }
}
