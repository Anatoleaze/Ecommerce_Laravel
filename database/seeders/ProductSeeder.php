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
        $types = ['hommes', 'femmes', 'chaussures', 'sacs', 'montres'];
 
        foreach ($types as $type) {
            Product::factory()
                ->count(5)
                ->state(['type' => $type])
                ->create();
        }
    }
}
