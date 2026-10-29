<?php

namespace Database\Factories;

use App\Models\PaymentRequest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PaymentRequest>
 */
class PaymentRequestFactory extends Factory
{
    protected $model = PaymentRequest::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement([
            'tmcell', 'tmcell', 'tmcell', 'tmcell',
            'telecom', 'telecom', 'telecom',
            'belet', 'belet',
            'charity',
            'cdma',
            'card', 'card', 'card',
            'certificate', 'certificate',
            'alem_tv', 'alem_iptv',
            'astu inet', 'astu phone', 'astu iptv', 'astu cdma',
        ]);

        $isOrder = in_array($type, ['card', 'certificate'], true);

        if ($isOrder) {
            $status = 'pending';
            $paymentStatus = fake()->randomElement(['pending', 'confirmed', 'confirmed', 'failed', 'not_required']);
        } else {
            $status = fake()->randomElement([
                'confirmed', 'confirmed', 'confirmed', 'confirmed',
                'pending', 'pending',
                'sent',
                'notConfirmed',
                'confirming',
                'failed', 'failed',
            ]);
            $paymentStatus = match ($status) {
                'confirmed' => 'confirmed',
                'failed' => 'failed',
                default => 'pending',
            };
        }

        return [
            'type' => $type,
            'external_id' => 'DUMMY-'.Str::ulid(),
            'status' => $status,
            'payment_status' => $paymentStatus,
            'amount' => number_format($this->amountFor($type), 2, '.', ''),
            'payment_target' => $this->targetFor($type),
            'meta' => ['dummy' => true],
            'created_at' => fake()->dateTimeBetween('-40 days', 'now'),
        ];
    }

    private function amountFor(string $type): float
    {
        return match (true) {
            $type === 'card' => fake()->randomFloat(2, 20, 250),
            $type === 'certificate' => fake()->randomFloat(2, 10, 80),
            $type === 'charity' => fake()->randomFloat(2, 5, 500),
            str_starts_with($type, 'alem_') => (float) fake()->randomElement([30, 45, 60, 90, 120]),
            default => fake()->randomFloat(2, 2, 100),
        };
    }

    /**
     * @return array<string, mixed>|null
     */
    private function targetFor(string $type): ?array
    {
        if (in_array($type, ['card', 'certificate'], true)) {
            return null;
        }

        if (str_starts_with($type, 'alem_')) {
            return [
                'tarif' => fake()->randomElement(['Standard', 'Family', 'Premium']),
                'period' => fake()->randomElement([1, 3, 6, 12]),
                'value' => fake()->numerify('6#######'),
            ];
        }

        return [
            'type' => 'phone',
            'value' => fake()->numerify('6#######'),
        ];
    }
}
