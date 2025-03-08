<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;

class UserRolesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_user_can_be_assigned_role()
    {
        $user = User::factory()->create();
        $user->assignRole('manager');

        $this->assertTrue($user->hasRole('manager'));
    }

    public function test_user_can_have_multiple_roles()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $user->assignRole('manager');

        $this->assertTrue($user->hasRole('admin'));
        $this->assertTrue($user->hasRole('manager'));
    }

    public function test_admin_has_all_permissions()
    {
        $admin = User::factory()->create()->assignRole('admin');

        $this->assertTrue($admin->can('manage users'));
        $this->assertTrue($admin->can('delete users'));
    }

    public function test_manager_has_limited_permissions()
    {
        $manager = User::factory()->create()->assignRole('manager');

        $this->assertTrue($manager->can('manage users'));
        $this->assertFalse($manager->can('delete users'));
    }
}
