<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = implode(' ', fake()->words(3));
        $slug = str_replace(' ', '_', strtolower($name));

        $price = fake()->randomFloat(2, 10, 500);
        $sale = $price - fake()->randomFloat(2, 1, 50);


        $imageSeed = md5($name . microtime(true) . rand());

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->text(),
            'image_name' => "https://placehold.co/640x480/1a1a2e/ffffff?text=" . urlencode($name),
            'price' => $price,
            'sale_price' => max($sale, 0),
            //'type' => $type,
        ];
    }
}