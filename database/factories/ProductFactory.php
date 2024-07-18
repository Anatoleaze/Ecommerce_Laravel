<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = implode(" ",fake()->words(3));
        $slug = str_replace(' ','_', strtolower($name));
        $price = fake()->randomFloat(2);
        $sale = $price - fake()->randomDigit();

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->text(),
            'image_name' => fake()->imageUrl(640, 480, 'product', true),
            'price' => $price,
            'sale_price' => $sale,
        ];
    }
}
