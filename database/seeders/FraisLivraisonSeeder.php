<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\FraisLivraison;
use Illuminate\Database\Seeder;

class FraisLivraisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
        $frais = [
            ['pays' => 'France', 'frais' => 5.99],
            ['pays' => 'Belgique', 'frais' => 7.50],
            ['pays' => 'Canada', 'frais' => 12.00],
            ['pays' => 'États-Unis', 'frais' => 10.00],
            ['pays' => 'Allemagne', 'frais' => 6.50]
        ];

        foreach ($frais as $item) {
            FraisLivraison::create($item);
        }
    }
}
