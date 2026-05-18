<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $types = ['homme', 'femme', 'chaussures', 'sacs', 'montres'];

        $perType = 10; // 50 produits → 10 par type

        foreach ($types as $type) {
            Product::factory()
                ->count($perType)
                ->state(['type' => $type])
                ->create();
        }
    }
}
