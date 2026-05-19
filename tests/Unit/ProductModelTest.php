<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    public function test_product_can_be_created()
    {
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 29.99,
            'description' => 'A test product',
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 29.99,
        ]);
    }

    public function test_product_has_correct_attributes()
    {
        $product = Product::factory()->create([
            'name' => 'Laptop',
            'price' => 999.99,
        ]);

        $this->assertEquals('Laptop', $product->name);
        $this->assertEquals(999.99, $product->price);
    }

    public function test_product_can_be_updated()
    {
        $product = Product::factory()->create([
            'name' => 'Old Name',
            'price' => 10.00,
        ]);

        $product->update([
            'name' => 'New Name',
            'price' => 20.00,
        ]);

        $this->assertEquals('New Name', $product->fresh()->name);
        $this->assertEquals(20.00, $product->fresh()->price);
    }

    public function test_product_can_be_deleted()
    {
        $product = Product::factory()->create();
        $productId = $product->id;

        $product->delete();

        $this->assertDatabaseMissing('products', ['id' => $productId]);
    }
}
