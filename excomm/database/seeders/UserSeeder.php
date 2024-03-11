<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Add this line

class UserSeeder extends Seeder
{
    public function run()
    {
        // Custom user data

        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ]);

        DB::table('users')->insert([ // Fix: Change equal sign to parentheses
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('secret456'),
        ]);

        // Add more custom users as needed

        // Insert custom users
        // User::insert($userData);

        // You can still use factories if you want a mix of custom and factory-generated data
        // User::factory()->count(5)->create();
    }
}
