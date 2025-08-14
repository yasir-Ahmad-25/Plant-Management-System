<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSales;
use App\Models\ProductSalesDetails;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Testing\Fakes\Fake;
use Faker\Factory as Faker;

class DemoSalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // 1) Create 5 categories (fixed names for clarity)
        $categoryNames = ['Indoor Plants', 'Outdoor Plants', 'Succulents', 'Herbs', 'Flowers'];
        foreach ($categoryNames as $name) {
            Category::firstOrCreate(
                ['category_name' => $name],
                ['category_description' => $faker->sentence(8)]
            );
        }

        // 2) Create 50 products across those categories
        // Ensure factory can resolve product_category_id
        $categories = Category::pluck('product_category_id')->all();

        Product::unguard();
        for ($i = 1; $i <= 50; $i++) {
            Product::updateOrCreate(
                ['product_name' => "Plant #$i"],
                [
                    'product_price' => $faker->randomFloat(2, 3, 150),
                    'product_category_id' => $faker->randomElement($categories),
                    'product_description' => $faker->sentence(12),
                ]
            );
        }
        Product::reguard();

        $productIds = Product::pluck('product_id')->all();

        // 3) Create 100 sales with 1–5 items each
        for ($s = 1; $s <= 100; $s++) {
            DB::transaction(function () use ($faker, $productIds) {
                // Create sale shell
                $sale = ProductSales::create([
                    'invoice_number'  => strtoupper($faker->unique()->bothify('INV-#####')),
                    'customer_name'   => $faker->name(),
                    'customer_number' => $faker->e164PhoneNumber(),
                    'customer_address'=> $faker->address(),
                    'sales_date'      => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'),
                    'discount'        => 0,
                    'delivery'        => 0,
                    'paid'            => 0,
                    'balance'         => 0,
                    'grand_total'     => 0,
                ]);

                $lineCount = $faker->numberBetween(1, 5);
                $lineProductIds = $faker->randomElements($productIds, $lineCount);

                $subtotal = 0;

                foreach ($lineProductIds as $pid) {
                    // Pull product price
                    $product = Product::where('product_id', $pid)->first();
                    $qty = $faker->numberBetween(1, 10);
                    $price = (float) $product->product_price;
                    $total = $qty * $price;

                    ProductSalesDetails::create([
                        'sale_id'    => $sale->sale_id,
                        'product_id' => $pid,
                        'quantity'   => $qty,
                        'price'      => $price,
                        'total'      => $total,
                    ]);

                    $subtotal += $total;
                }

                // Delivery + discount randomized for realism
                $delivery = $faker->randomElement([0, 2.50, 5.00, 10.00]);
                $maxDiscount = min(20, $subtotal * 0.2); // cap at 20 or 20% of subtotal
                $discount = $faker->randomFloat(2, 0, $maxDiscount);

                $grandTotal = max(0, $subtotal + $delivery - $discount);
                $paid = $faker->randomFloat(2, 0, $grandTotal);
                $balance = round($grandTotal - $paid, 2);

                // Update sale totals
                $sale->update([
                    'discount'    => round($discount, 2),
                    'delivery'    => round($delivery, 2),
                    'grand_total' => round($grandTotal, 2),
                    'paid'        => round($paid, 2),
                    'balance'     => $balance,
                ]);
            });
        }
    }
}
