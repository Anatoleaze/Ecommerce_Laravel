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
                'statut' => 'pending',
                'methode_paiement' => 'CB',
                'adresse_livraison' => '4 route de la garre, 14000 Caen',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_number' => strtoupper(Str::random(10)),
                'user_id' => 1,
                'total' => 6212.89,
                'statut' => 'pending',
                'methode_paiement' => 'CB',
                'adresse_livraison' => '4 route de la garre, 14000 Caen',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }

    private function generateOrderNumber()
    {
        return 'ORD-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(4));
    }

}
