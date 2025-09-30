<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Lucas Gabriel Costa',
            'phone_number' => '5543996810625',
            'email' => 'admin@lucasgabriel.dev',
            'password_hash' => Hash::make('senha123'),
            'permission_level' => 'USER',
        ]);
    }
}