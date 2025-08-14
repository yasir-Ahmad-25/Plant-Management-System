<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductSalesDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->value('product_id'),
            'quantity'   => $this->faker->numberBetween(1, 10),
            'price'      => 0, // set from product_price
            'total'      => 0, // quantity * price
        ];
    }
}
