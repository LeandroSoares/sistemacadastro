<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PersonalData;
use App\Models\ReligiousInfo;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário admin principal
        $user = User::create([
            'name' => 'Leandro Silva Soares',
            'email' => 'leandrogamedesigner@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $user->assignRole('admin');

        // Criar um usuário admin adicional
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        // Criar 100 usuários aleatórios
        User::factory()->count(100)->create()->each(function ($user) {
            // Atribuir aleatoriamente uma função (manager ou user) para cada usuário
            $role = rand(0, 1) ? 'manager' : 'user';
            $user->assignRole($role);
        });
    }
}
