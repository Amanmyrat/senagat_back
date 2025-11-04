<?php

namespace Database\Seeders;

use App\Models\CardType;
use Illuminate\Database\Seeder;

class CardTypeSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('data/cardTypes.json');

        if (! file_exists($jsonPath)) {
            $this->command->error('CardTypes JSON file not found!');

            return;
        }

        $json = file_get_contents($jsonPath);
        $products = json_decode($json, true);

        foreach ($products as $product) {
            $cardType = CardType::where('image_url', $product['image_url'])->first();

            if ($cardType) {
                $cardType->update([
                    'title' => $product['title'],
                    'price' => $product['price'] ?? 0,
                    'advantages' => $product['advantages'] ?? [],
                    'text' => $product['text'] ?? [],
                    'category' => $product['category'] ?? null,
                ]);
            } else {
                CardType::create([
                    'title' => $product['title'],
                    'image_url' => $product['image_url'] ?? null,
                    'price' => $product['price'] ?? 0,
                    'advantages' => $product['advantages'] ?? [],
                    'text' => $product['text'] ?? [],
                    'category' => $product['category'] ?? null,
                ]);
            }
        }

        $this->command->info('Card Types added/updated successfully!');
    }
}
