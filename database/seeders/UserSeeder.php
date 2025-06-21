<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

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

        // Criar usuários fictícios para teste de exportação CSV
        // 5 usuários com papel de manager
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('manager');
        });

        // 15 usuários com papel de user
        User::factory(15)->create()->each(function ($user) {
            $user->assignRole('user');
        });

        // 3 usuários com múltiplos papéis
        User::factory(3)->create()->each(function ($user) {
            $user->assignRole(['manager', 'user']);
        });

        // Total: 24 usuários + o admin principal = 25 usuários
        $this->command->info('Criados 24 usuários de teste para exportação CSV');
    }
}
