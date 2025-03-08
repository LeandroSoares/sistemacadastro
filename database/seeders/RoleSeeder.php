<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Criar funções básicas
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $user = Role::create(['name' => 'user']);

        // Criar permissões básicas
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'view courses']);
        Permission::create(['name' => 'create courses']);
        Permission::create(['name' => 'edit courses']);
        Permission::create(['name' => 'delete courses']);

        // Adicionar permissões para Orishas
        Permission::create(['name' => 'view orishas']);
        Permission::create(['name' => 'create orishas']);
        Permission::create(['name' => 'edit orishas']);
        Permission::create(['name' => 'delete orishas']);

        // Atribuir permissões às funções
        $admin->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
            'view orishas',
            'create orishas',
            'edit orishas',
            'delete orishas'
        ]);

        $manager->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'view courses',
            'create courses',
            'edit courses',
            'view orishas',
            'create orishas',
            'edit orishas'
        ]);

        $user->givePermissionTo([
            'view courses',
            'view orishas'
        ]);
    }
}
