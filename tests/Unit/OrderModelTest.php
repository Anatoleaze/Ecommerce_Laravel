<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderModelTest extends TestCase
{
    // Utilise ce trait pour vider la base de données de test à chaque lancement
    use RefreshDatabase;

    public function test_order_can_be_created()
    {
        $user = User::factory()->create();

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'numero_commande' => 'CMD-' . strtoupper(Str::random(8)), // Ajout du champ requis
            'total' => 100.00,
            'statut' => 'payé', // 'status' devient 'statut' et 'pending' devient 'payé'
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total' => 100.00,
            'statut' => 'payé',
        ]);
    }

    public function test_order_belongs_to_user()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'numero_commande' => 'CMD-' . strtoupper(Str::random(8)),
        ]);

        $this->assertInstanceOf(User::class, $order->user);
        $this->assertEquals($user->id, $order->user->id);
    }

    public function test_order_has_correct_status()
    {
        $order = Order::factory()->create([
            'numero_commande' => 'CMD-' . strtoupper(Str::random(8)),
            'statut' => 'livrée', // 'status' devient 'statut' et 'completed' devient 'livrée'
        ]);

        $this->assertEquals('livrée', $order->statut);
    }
}