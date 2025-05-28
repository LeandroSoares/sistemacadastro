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
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $admin->refresh();

        $this->assertTrue($admin->can('delete users'));
        $this->assertTrue($admin->can('create users'));
        $this->assertTrue($admin->can('edit users'));
        $this->assertTrue($admin->can('view users'));
        $this->assertTrue($admin->can('view courses'));
        $this->assertTrue($admin->can('delete courses'));
        $this->assertTrue($admin->can('view orishas'));
        $this->assertTrue($admin->can('delete orishas'));
    }

    public function test_manager_has_limited_permissions()
    {
        $manager = User::factory()->create();
        $manager->assignRole('manager');
        $manager->refresh();

        $this->assertTrue($manager->can('view users'));
        $this->assertTrue($manager->can('create users'));
        $this->assertTrue($manager->can('edit users'));
        $this->assertFalse($manager->can('delete users'));
        $this->assertTrue($manager->can('view courses'));
        $this->assertTrue($manager->can('create courses'));
        $this->assertTrue($manager->can('edit courses'));
        $this->assertFalse($manager->can('delete courses'));
        $this->assertTrue($manager->can('view orishas'));
        $this->assertTrue($manager->can('create orishas'));
        $this->assertTrue($manager->can('edit orishas'));
        $this->assertFalse($manager->can('delete orishas'));
    }
}
