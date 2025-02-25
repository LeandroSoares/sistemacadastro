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
        $manageUsers = Permission::create(['name' => 'manage users']);
        $createUsers = Permission::create(['name' => 'create users']);
        $editUsers = Permission::create(['name' => 'edit users']);
        $deleteUsers = Permission::create(['name' => 'delete users']);
        $viewUsers = Permission::create(['name' => 'view users']);

        // Atribuir permissões às funções
        $admin->givePermissionTo([
            'manage users',
            'create users',
            'edit users',
            'delete users',
            'view users'
        ]);

        $manager->givePermissionTo([
            'create users',
            'edit users',
            'view users'
        ]);
    }
}
