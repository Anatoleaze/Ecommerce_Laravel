<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Basket;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    protected User $user;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->product = Product::factory()->create(['price' => 29.99]);
    }

    public function test_cart_index_requires_authentication()
    {
        $response = $this->getJson('/api/cart');

        $response->assertStatus(401);
    }

    public function test_cart_index_returns_user_basket()
    {
        Basket::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $response = $this->actingAs($this->user)->getJson('/api/cart');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_add_product_to_cart()
    {
        $response = $this->actingAs($this->user)->postJson('/api/cart', [
            'product_id' => $this->product->id,
            'quantity' => 2,
            'price' => 29.99,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Produit ajouté au panier']);

        $this->assertDatabaseHas('baskets', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'qty' => 2,
        ]);
    }

    public function test_get_cart_count()
    {
        Basket::factory()->create([
            'user_id' => $this->user->id,
            'qty' => 3,
        ]);

        $response = $this->actingAs($this->user)->getJson('/api/cart/count');

        $response->assertStatus(200);
        $response->assertJsonFragment(['count' => 3]);
    }

    public function test_remove_product_from_cart()
    {
        Basket::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $response = $this->actingAs($this->user)->deleteJson('/api/cart/' . $this->product->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('baskets', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
    }

    public function test_update_cart_item()
    {
        Basket::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'qty' => 1,
        ]);

        $response = $this->actingAs($this->user)->putJson('/api/cart/update', [
            'product_id' => $this->product->id,
            'quantity' => 5,
            'price' => 29.99,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('baskets', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'qty' => 5,
        ]);
    }
}
