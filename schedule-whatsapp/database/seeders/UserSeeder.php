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
        // Criar usuário administrador
        User::create([
            'email' => 'admin@example.com',
            'password_hash' => Hash::make('password123'),
            'permission_level' => 'admin',
        ]);
    }
}