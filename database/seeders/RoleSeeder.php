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
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view users']);

        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'create courses']);
        Permission::create(['name' => 'edit courses']);
        Permission::create(['name' => 'delete courses']);
        Permission::create(['name' => 'view courses']);

        // Atribuir permissões às funções
        $admin->givePermissionTo([
            'manage users',
            'create users',
            'edit users',
            'delete users',
            'view users'
        ]);

        $manager->givePermissionTo([
            'manage users',
            'create users',
            'edit users',
            'view users'
        ]);

        $user->givePermissionTo([
            'view courses'
        ]);
    }
}
