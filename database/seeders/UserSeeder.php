<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário admin principal com senha definida no .env ou usando fallback seguro
        $adminPassword = env('ADMIN_PASSWORD') ?: Str::random(16);

        $user = User::create([
            'name' => 'Leandro Silva Soares',
            'email' => 'leandrogamedesigner@gmail.com',
            'password' => bcrypt($adminPassword)
        ]);
        $user->assignRole(['admin', 'user', 'manager']);

        // Em ambiente de desenvolvimento, se a senha foi gerada automaticamente, informar no log
        if (app()->environment('local') && !env('ADMIN_PASSWORD')) {
            \Log::info('Senha de administrador gerada automaticamente: ' . $adminPassword);
            echo "Senha de administrador gerada automaticamente: {$adminPassword}" . PHP_EOL;
        }
    }
}
