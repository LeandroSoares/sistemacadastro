<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário admin principal
        $user = User::create([
            'name' => 'Leandro Silva Soares',
            'email' => 'leandrogamedesigner@gmail.com',
            'password' => bcrypt('123456789')
        ]);
        $user->assignRole(['admin', 'user', 'manager']);
    }
}
