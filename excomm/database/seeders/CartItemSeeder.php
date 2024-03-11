<?php

use Illuminate\Database\Seeder;
use App\Models\CartItem;

class CartItemSeeder extends Seeder
{
    public function run()
    {
        // Custom cart item data
        $cartItemData = [
            [
                'cart_id' => 1,
                'product_id' => 3,
                'quantity' => 2,
                'price' => 199.99,
            ],
            [
                'cart_id' => 2,
                'product_id' => 5,
                'quantity' => 1,
                'price' => 99.99,
            ],
            // Add more custom cart items as needed
        ];

        // Insert custom cart items
        CartItem::insert($cartItemData);

        // You can still use factories if you want a mix of custom and factory-generated data
        CartItem::factory()->count(20)->create();
    }
}
