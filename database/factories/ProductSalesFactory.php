<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSales>
 */
class ProductSalesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-6 months', 'now');
        return [
            'invoice_number'  => strtoupper($this->faker->unique()->bothify('INV-#####')),
            'customer_name'   => $this->faker->name(),
            'customer_number' => $this->faker->e164PhoneNumber(),
            'customer_address'=> $this->faker->address(),
            'sales_date'      => $date->format('Y-m-d H:i:s'),
            'discount'        => 0,    // will set after details
            'delivery'        => 0,
            'paid'            => 0,
            'balance'         => 0,
            'grand_total'     => 0,
        ];
    }
}
