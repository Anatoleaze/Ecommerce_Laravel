<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer les utilisateurs
        User::factory(15)->create();
        
        // Créer un utilisateur de test
        User::factory()->create([
            'name' => 'Test User',
            'first_name' => 'Test',
            'role' => 'admin',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ])->each(function ($user) {

        $user->address()->create(
            \App\Models\Address::factory()->make()->toArray()
        );

    });

        $this->call([
            ProductSeeder::class,
            PromoSeeder::class,
            FraisLivraisonSeeder::class,
            OrderSeeder::class,
            OrderDetailsSeeder::class,
        ]);
    }
}
