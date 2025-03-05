<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'address' => 'Via delsetti 33',
            'zip_code' => '6900',
            'city' => 'Lugano',
        ]);
        User::insert([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'address' => 'Via camaretti 5',
            'zip_code' => '6900',
            'city' => 'Lugano',
        ]);
        
    }
}
