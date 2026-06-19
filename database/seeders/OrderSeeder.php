<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'numero_commande' => $this->generateOrderNumber(),
                'user_id' => 1,
                'total' => 8189.66,
                'statut' => 'payé', // Le statut par défaut après succès Stripe
                'methode_paiement' => 'CB',
                'adresse_livraison' => '4 route de la garre, 14000 Caen',
                'created_at' => Carbon::now()->subDays(2), // Passée il y a 2 jours
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'numero_commande' => $this->generateOrderNumber(),
                'user_id' => 1,
                'total' => 6212.89,
                'statut' => 'expédié', // Un autre statut pour tester tes composants Vue / vues Blade
                'methode_paiement' => 'CB',
                'adresse_livraison' => '4 route de la garre, 14000 Caen',
                'created_at' => Carbon::now(), // Passée aujourd'hui
                'updated_at' => Carbon::now(),
            ],
        ]);
    }

    /**
     * Génère un numéro de commande unique (Format: CMD-8 caractères aléatoires)
     * Aligné avec la logique mise en place dans ton OrderController
     */
    private function generateOrderNumber()
    {
        return 'CMD-' . strtoupper(Str::random(8));
    }
}