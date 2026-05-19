<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function test_home_page_returns_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    public function test_home_page_returns_products()
    {
        Product::factory()->count(10)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('products');
    }

    public function test_home_page_has_pagination()
    {
        Product::factory()->count(15)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $this->assertCount(8, $response->viewData('products'));
    }
}
