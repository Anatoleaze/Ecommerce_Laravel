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
                'statut' => 'paye',
                'methode_paiement' => 'CB',
                'payment_intent_id' => 'demo_pi_' . strtoupper(Str::random(10)), // Pour simuler Stripe
                'adresse_livraison' => '4 route de la garre, 14000 Caen',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'numero_commande' => $this->generateOrderNumber(),
                'user_id' => 1,
                'total' => 6212.89,
                'statut' => 'livre', 
                'methode_paiement' => 'CB',
                'payment_intent_id' => 'demo_pi_' . strtoupper(Str::random(10)), //  Pour simuler Stripe
                'adresse_livraison' => '4 route de la garre, 14000 Caen',
                'created_at' => Carbon::now(),
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