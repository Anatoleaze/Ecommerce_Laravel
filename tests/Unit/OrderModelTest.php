<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class OrderModelTest extends TestCase
{
    public function test_order_can_be_created()
    {
        $user = User::factory()->create();

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'total' => 100.00,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total' => 100.00,
        ]);
    }

    public function test_order_belongs_to_user()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $order->user);
        $this->assertEquals($user->id, $order->user->id);
    }

    public function test_order_has_correct_status()
    {
        $order = Order::factory()->create(['status' => 'completed']);

        $this->assertEquals('completed', $order->status);
    }
}
