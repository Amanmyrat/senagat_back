<?php

namespace Database\Seeders;

use App\Models\CreditType;
use Illuminate\Database\Seeder;

class CreditTypeSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('data/creditTypes.json');

        if (! file_exists($jsonPath)) {
            $this->command->error('CreditTypes JSON file not found!');

            return;
        }

        $json = file_get_contents($jsonPath);
        $products = json_decode($json, true);

        foreach ($products as $product) {

            CreditType::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'term' => $product['term'],
                'min_amount' => $product['min_amount'],
                'max_amount' => $product['max_amount'],
                'interest' => $product['interest'],
            ]);

        }

        $this->command->info('Credit Types added/updated successfully!');
    }
}
