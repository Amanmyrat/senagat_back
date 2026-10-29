<?php

namespace App\Services;

use App\Models\PaymentRequest;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;

class PaymentReportService
{
    public const CURRENCY = 'TMT';

    public const TYPES = [
        'tmcell',
        'telecom',
        'belet',
        'charity',
        'cdma',
        'card',
        'certificate',
        'alem_tv',
        'alem_iptv',
        'astu inet',
        'astu cdma',
        'astu phone',
        'astu iptv',
    ];

    public const STATUSES = [
        'sent',
        'pending',
        'notConfirmed',
        'confirming',
        'confirmed',
        'failed',
    ];

    /**
     * @param  array{from?: mixed, to?: mixed, types?: mixed, statuses?: mixed}  $filters
     * @return array{
     *     from: string,
     *     to: string,
     *     type_label: string,
     *     status_label: string,
     *     count: int,
     *     amount: float,
     *     confirmed_amount: float,
     *     failed_amount: float,
     *     average: float,
     *     by_status: array<int, array{label: string, count: int, amount: float, share: float}>,
     *     by_payment_status: array<int, array{label: string, count: int, amount: float, share: float}>,
     *     by_type: array<int, array{label: string, count: int, amount: float, share: float}>,
     *     by_day: array<int, array{label: string, count: int, amount: float, share: float}>
     * }
     */
    public function summarize(array $filters): array
    {
        [$from, $to] = $this->bounds($filters);
        $types = $this->selected($filters['types'] ?? []);
        $statuses = $this->selected($filters['statuses'] ?? []);

        $totals = $this->filtered($filters)
            ->selectRaw(
                'COUNT(*) as payment_count,
                COALESCE(SUM(amount), 0) as amount_cents,
                COALESCE(SUM(CASE WHEN status = ? THEN amount ELSE 0 END), 0) as confirmed_cents,
                COALESCE(SUM(CASE WHEN status = ? THEN amount ELSE 0 END), 0) as failed_cents',
                ['confirmed', 'failed'],
            )
            ->first();

        $count = (int) ($totals->payment_count ?? 0);
        $amount = $this->fromCents($totals->amount_cents ?? 0);

        return [
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'type_label' => $this->selectionLabel($types, self::typeLabel(...)),
            'status_label' => $this->selectionLabel($statuses, self::statusLabel(...)),
            'count' => $count,
            'amount' => $amount,
            'confirmed_amount' => $this->fromCents($totals->confirmed_cents ?? 0),
            'failed_amount' => $this->fromCents($totals->failed_cents ?? 0),
            'average' => $count > 0 ? round($amount / $count, 2) : 0.0,
            'by_status' => $this->breakdown($filters, 'status', 'status', 'status'),
            'by_payment_status' => $this->breakdown(
                $filters,
                "COALESCE(NULLIF(payment_status, ''), 'none')",
                "COALESCE(NULLIF(payment_status, ''), 'none')",
                'status',
            ),
            'by_type' => $this->breakdown($filters, 'type', 'type', 'type'),
            'by_day' => $this->breakdown(
                $filters,
                'CAST(created_at AS DATE)',
                'CAST(created_at AS DATE)',
                'day',
                'bucket',
                'asc',
            ),
        ];
    }

    /**
     * @param  array{from?: mixed, to?: mixed, types?: mixed, statuses?: mixed}  $filters
     */
    public function detailQuery(array $filters): Builder
    {
        return $this->filtered($filters)
            ->with('user:id,name,phone')
            ->orderBy('created_at')
            ->orderBy('id');
    }

    /**
     * @return array<string, string>
     */
    public static function typeOptions(): array
    {
        $stored = PaymentRequest::query()
            ->whereNotNull('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type')
            ->all();

        $options = [];

        foreach (array_unique([...self::TYPES, ...$stored]) as $type) {
            $options[(string) $type] = self::typeLabel((string) $type);
        }

        asort($options);

        return $options;
    }

    /**
     * @return array<string, string>
     */
    public static function statusOptions(): array
    {
        $options = [];

        foreach (self::STATUSES as $status) {
            $options[$status] = self::statusLabel($status);
        }

        return $options;
    }

    public static function typeLabel(string $type): string
    {
        $key = 'resource.payment_types.'.str_replace(' ', '_', $type);
        $label = __($key);

        return $label === $key ? $type : $label;
    }

    public static function statusLabel(?string $status): string
    {
        if ($status === null || $status === '' || $status === 'none') {
            return __('resource.not_set');
        }

        $key = 'resource.'.$status;
        $label = __($key);

        return $label === $key ? $status : $label;
    }

    public static function targetLabel(PaymentRequest $payment): string
    {
        $target = $payment->payment_target ?? [];
        $value = trim((string) ($target['value'] ?? ''));
        $extra = [];

        if (filled($target['tarif'] ?? null)) {
            $extra[] = (string) $target['tarif'];
        }

        if (filled($target['period'] ?? null)) {
            $extra[] = (string) $target['period'];
        }

        if ($extra === []) {
            return $value;
        }

        $suffix = implode(', ', $extra);

        return $value === '' ? $suffix : $value.' ('.$suffix.')';
    }

    public static function formatMoney(float|int $amount): string
    {
        return number_format((float) $amount, 2, '.', ' ').' '.self::CURRENCY;
    }

    public static function formatShare(float $share): string
    {
        return number_format($share * 100, 1).'%';
    }

    /**
     * @param  array{from?: mixed, to?: mixed, types?: mixed, statuses?: mixed}  $filters
     */
    private function filtered(array $filters): Builder
    {
        [$from, $to] = $this->bounds($filters);
        $types = $this->selected($filters['types'] ?? []);
        $statuses = $this->selected($filters['statuses'] ?? []);

        return PaymentRequest::query()
            ->whereBetween('created_at', [$from, $to])
            ->when($types !== [], fn (Builder $query) => $query->whereIn('type', $types))
            ->when($statuses !== [], fn (Builder $query) => $query->whereIn('status', $statuses));
    }

    /**
     * @param  array{from?: mixed, to?: mixed, types?: mixed, statuses?: mixed}  $filters
     * @return array<int, array{label: string, count: int, amount: float, share: float}>
     */
    private function breakdown(
        array $filters,
        string $select,
        string $group,
        string $labelAs,
        string $orderColumn = 'amount_cents',
        string $direction = 'desc',
    ): array {
        $totalCents = (int) $this->filtered($filters)->sum('amount');

        $rows = $this->filtered($filters)
            ->selectRaw("{$select} as bucket, COUNT(*) as payment_count, COALESCE(SUM(amount), 0) as amount_cents")
            ->groupByRaw($group)
            ->orderBy($orderColumn, $direction)
            ->get();

        return $rows->map(function ($row) use ($labelAs, $totalCents) {
            $cents = (int) $row->amount_cents;

            return [
                'label' => $this->labelFor($labelAs, $row->bucket),
                'count' => (int) $row->payment_count,
                'amount' => $this->fromCents($cents),
                'share' => $totalCents > 0 ? $cents / $totalCents : 0.0,
            ];
        })->all();
    }

    private function labelFor(string $kind, mixed $bucket): string
    {
        if ($bucket instanceof DateTimeInterface) {
            $bucket = $bucket->format('Y-m-d');
        }

        $value = (string) $bucket;

        return match ($kind) {
            'type' => self::typeLabel($value),
            'day' => substr($value, 0, 10),
            default => self::statusLabel($value),
        };
    }

    /**
     * @param  array{from?: mixed, to?: mixed, types?: mixed, statuses?: mixed}  $filters
     * @return array{0: Carbon, 1: Carbon}
     */
    private function bounds(array $filters): array
    {
        $from = filled($filters['from'] ?? null)
            ? Carbon::parse($filters['from'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $to = filled($filters['to'] ?? null)
            ? Carbon::parse($filters['to'])->endOfDay()
            : now()->endOfDay();

        if ($from->greaterThan($to)) {
            [$from, $to] = [$to->copy()->startOfDay(), $from->copy()->endOfDay()];
        }

        return [$from, $to];
    }

    /**
     * @return array<int, string>
     */
    private function selected(mixed $values): array
    {
        if (! is_array($values)) {
            return [];
        }

        return array_values(array_filter(
            $values,
            fn ($value) => is_string($value) && $value !== '',
        ));
    }

    /**
     * @param  array<int, string>  $values
     */
    private function selectionLabel(array $values, callable $labeler): string
    {
        if ($values === []) {
            return __('resource.all');
        }

        return collect($values)->map($labeler)->implode(', ');
    }

    private function fromCents(mixed $cents): float
    {
        return round(((int) $cents) / 100, 2);
    }
}
