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
        //
        $brands = ['Nike', 'Adidas', 'Puma', 'Converse', 'Vans', 'Reebok'];
        $categories = ['sneakers', 'shirts', 'accessories', 'pants'];
        $color = ['red', 'blue', 'green', 'yellow', 'black', 'white'];
        return [
            'title' => $this->faker->words(3, true), // random product name
            'img' => $this->faker->imageUrl(640, 480, 'fashion', true), // random image url
            'prev_price' => $this->faker->randomFloat(2, 100, 300),
            'new_price' => $this->faker->randomFloat(2, 50, 250),
            'rating' => $this->faker->numberBetween(0, 5),
            'reviews' => "({$this->faker->numberBetween(0, 500)} reviews)",
            'company' => $this->faker->company(),
            'brand' => $this->faker->randomElement($brands),
            'category' => $this->faker->randomElement($categories),
            'color' => $this->faker->randomElement($color),
        ];
    }
}
