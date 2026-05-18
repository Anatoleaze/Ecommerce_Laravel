<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promos = [
            [
                'code' => 'WELCOME2024',
                'remise' => 10,
                'min_achat' => 50,
                'started_at' => Carbon::now()->toDateString(),
                'expired_at' => Carbon::now()->addDays(30)->toDateString(),
            ],
            [
                'code' => 'SUMMER50',
                'remise' => 50,
                'min_achat' => 100,
                'started_at' => Carbon::now()->toDateString(),
                'expired_at' => Carbon::now()->addDays(60)->toDateString(),
            ],
            [
                'code' => 'VIP20',
                'remise' => 20,
                'min_achat' => 75,
                'started_at' => Carbon::now()->toDateString(),
                'expired_at' => Carbon::now()->addDays(45)->toDateString(),
            ],
            [
                'code' => 'NEWUSER15',
                'remise' => 15,
                'min_achat' => 30,
                'started_at' => Carbon::now()->toDateString(),
                'expired_at' => Carbon::now()->addDays(90)->toDateString(),
            ],
        ];

        foreach ($promos as $promo) {
            Promo::create($promo);
        }
    }
}
