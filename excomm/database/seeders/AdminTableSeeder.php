<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456');
        $adminRecords = [
            ['id' => 1, 'name' => 'Admin', 'type' => 'admin', 'mobile' => 9999999999, 'email' => 'admin@gmail.com', 'password' => $password, 'image' => '', 'status' => 1],
            ['id' => 2, 'name' => 'Admin2', 'type' => 'admin', 'mobile' => 9299999999, 'email' => 'admin1@gmail.com', 'password' => $password, 'image' => '', 'status' => 1],
            ['id' => 3, 'name' => 'SubAdmin1', 'type' => 'subadmin', 'mobile' => 9199999999, 'email' => 'subadmin1@gmail.com', 'password' => $password, 'image' => '', 'status' => 1],
            ['id' => 4, 'name' => 'SubAdmin2', 'type' => 'subadmin', 'mobile' => 9099999999, 'email' => 'subadmin2@gmail.com', 'password' => $password, 'image' => '', 'status' => 1],
        ];
        Admin::insert($adminRecords);
    }
}
