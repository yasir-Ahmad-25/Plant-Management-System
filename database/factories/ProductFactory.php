<?php

namespace Database\Factories;

use App\Models\Category;
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
        return [
            'product_name' => ucfirst($this->faker->unique()->words(2, true)),
            'product_price' => $this->faker->randomFloat(2, 3, 150), // $3 – $150
            'product_category_id' => Category::inRandomOrder()->value('product_category_id'),
            'product_description' => $this->faker->sentence(10),
        ];
    }
}
