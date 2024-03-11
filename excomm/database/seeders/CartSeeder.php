<?php

use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    public function run()
    {
        // Custom cart data
        $cartData = [
            [
                'user_id' => 1,
                'total_price' => 0.00,
            ],
            [
                'user_id' => 2,
                'total_price' => 0.00,
            ],
            // Add more custom carts as needed
        ];

        // Insert custom carts
        Cart::insert($cartData);

        // You can still use factories if you want a mix of custom and factory-generated data
        Cart::factory()->count(3)->create();
    }
}
