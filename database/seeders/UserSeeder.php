<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('admin123')
            ],
            [
                'name' => 'Penjahit',
                'email' => 'penjahit@gmail.com',
                'role' => 'penjahit',
                'password' => bcrypt('admin123')
            ],
            [
                'name' => 'asri',
                'email' => 'asri@gmail.com',
                'role' => 'user',
                'password' => bcrypt('admin123')
            ],
            
        ];
        foreach ($userData as $key => $value) {
            User::create($value);
        }
    }
}
