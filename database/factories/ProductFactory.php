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

        /*$type = fake()->randomElement([
            'homme',
            'femme',
            'chaussures',
            'sacs',
            'montres'
        ]); */

        // 🔥 image unique garantie via seed basé sur le nom
        $imageSeed = md5($name . microtime(true) . rand());

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->text(),
            'image_name' => "https://picsum.photos/seed/{$imageSeed}/640/480",
            'price' => $price,
            'sale_price' => max($sale, 0),
            //'type' => $type,
        ];
    }
}