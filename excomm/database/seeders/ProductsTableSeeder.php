<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'category_id' => rand(1, 4), // Assuming you have categories with IDs 1 to 5
                'subcategory_id' => rand(1, 4),
                'vender_id' => rand(1, 4),
                'name' => 'Product ' . $i,
                'color' => 'Color ' . $i,
                'titel' => 'Title ' . $i,
                'description' => 'Description for Product ' . $i,
                'saling_price' => rand(50, 200),
                'product_image'=>'1708922099_placeholder-image.png',
                'quintity'=>rand(500, 2000),
                'meta_title' => 'Meta Title ' . $i,
                'meta_description' => 'Meta Description for Product ' . $i,
                'meta_keywords' => 'Keyword' . $i . ', AnotherKeyword',
                'isfeatured' => rand(0, 1) ? 'yes' : 'NO',
                'status' => 1,
            ]);
        }
    }
}
