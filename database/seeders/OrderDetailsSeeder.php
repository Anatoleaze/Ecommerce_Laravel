<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class OrderDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_details')->insert([
            [
                'order_id' => 1, 
                'product_id' => 4,
                'quantity' => 1,
                'price' => 333.83,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => 1, 
                'product_id' => 5,
                'quantity' => 2,
                'price' => 661.58,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => 1, 
                'product_id' => 6,
                'quantity' => 3,
                'price' => 6437.24,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],   
            [
                'order_id' => 1, 
                'product_id' => 7,
                'quantity' => 4,
                'price' => 2666.32,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => 2, 
                'product_id' => 7,
                'quantity' => 1,
                'price' => 666.58,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => 2, 
                'product_id' => 6,
                'quantity' => 2,
                'price' => 3218.62,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => 2, 
                'product_id' => 5,
                'quantity' => 3,
                'price' => 992.37,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => 2, 
                'product_id' => 4,
                'quantity' => 4,
                'price' => 1335.32,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
