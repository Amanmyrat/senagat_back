<?php

namespace Database\Seeders;

use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class PaymentRequestSeeder extends Seeder
{
    public function run(): void
    {
        $deleted = PaymentRequest::query()
            ->where('external_id', 'like', 'DUMMY-%')
            ->delete();

        $users = $this->payers();

        PaymentRequest::factory()
            ->count(72)
            ->state(fn () => [
                'user_id' => fake()->boolean(80) ? $users->random()->id : null,
            ])
            ->create();

        $this->command?->info("Replaced {$deleted} dummy payments with 72 new ones.");
    }

    /**
     * @return Collection<int, User>
     */
    private function payers(): Collection
    {
        $people = [
            ['name' => 'Myrat Annayev', 'phone' => '65990001'],
            ['name' => 'Ayna Berdiyeva', 'phone' => '65990002'],
            ['name' => 'Serdar Orazov', 'phone' => '65990003'],
            ['name' => 'Jeren Atayeva', 'phone' => '65990004'],
            ['name' => 'Dowlet Nuryyev', 'phone' => '65990005'],
            ['name' => 'Mahri Gurbanova', 'phone' => '65990006'],
        ];

        return collect($people)->map(function (array $person) {
            $user = User::query()->firstOrNew(['phone' => $person['phone']]);

            if (! $user->exists) {
                $attributes = [
                    'name' => $person['name'],
                    'phone' => $person['phone'],
                    'password' => 'password',
                ];

                if (Schema::hasColumn('users', 'email')) {
                    $attributes['email'] = $person['phone'].'@example.com';
                }

                $user->forceFill($attributes)->save();
            }

            return $user;
        });
    }
}
