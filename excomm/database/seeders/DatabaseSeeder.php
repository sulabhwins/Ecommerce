<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use App\Models\ItemsStorage;

use CartItemSeeder;
use CartSeeder;
use Illuminate\Database\Seeder;
use UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(AdminTableSeeder::class);
        $this->call(CmsPageTableSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(ProductsTableSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(StorageSeeder::class);
        // $this->call(ProductImagesTableSeeder::class);
        // $this->call(CartSeeder::class);
        // $this->call(CartItemSeeder::class);
        // $this->call(UserSeeder::class);

    }

}
