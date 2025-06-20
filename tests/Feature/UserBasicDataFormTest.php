<?php

namespace Tests\Feature;

use App\Livewire\UserBasicDataForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserBasicDataFormTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        // Criar roles necessárias para os testes
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'user']);
    }

    /** @test */
    public function can_mount_component_with_existing_user()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        Livewire::test(UserBasicDataForm::class, ['user' => $user])
            ->assertSet('name', $user->name)
            ->assertSet('email', $user->email)
            ->assertSet('isCreating', false);
    }

    /** @test */
    public function can_mount_component_for_new_user()
    {
        $user = new User();

        Livewire::test(UserBasicDataForm::class, ['user' => $user])
            ->assertSet('name', '')
            ->assertSet('email', '')
            ->assertSet('isCreating', true);
    }

    /** @test */
    public function can_create_new_user()
    {
        $userRole = Role::where('name', 'user')->first();

        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'selectedRoles' => [$userRole->id],
        ];

        Livewire::test(UserBasicDataForm::class, ['user' => new User()])
            ->set('name', $userData['name'])
            ->set('email', $userData['email'])
            ->set('password', $userData['password'])
            ->set('password_confirmation', $userData['password_confirmation'])
            ->set('selectedRoles', $userData['selectedRoles'])
            ->call('save');

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);

        $newUser = User::where('email', $userData['email'])->first();
        $this->assertTrue($newUser->hasRole('user'));
    }

    /** @test */
    public function can_update_existing_user()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->safeEmail;

        Livewire::test(UserBasicDataForm::class, ['user' => $user])
            ->set('name', $newName)
            ->set('email', $newEmail)
            ->call('save')
            ->assertDispatched('close-modal');

        $user->refresh();
        $this->assertEquals($newName, $user->name);
        $this->assertEquals($newEmail, $user->email);
    }

    /** @test */
    public function can_update_password_for_existing_user()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $newPassword = 'newpassword123';

        Livewire::test(UserBasicDataForm::class, ['user' => $user])
            ->set('password', $newPassword)
            ->set('password_confirmation', $newPassword)
            ->call('save');

        $user->refresh();
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    /** @test */
    public function validates_required_fields_for_new_user()
    {
        Livewire::test(UserBasicDataForm::class, ['user' => new User()])
            ->call('save')
            ->assertHasErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function validates_password_confirmation_match()
    {
        Livewire::test(UserBasicDataForm::class, ['user' => new User()])
            ->set('name', $this->faker->name)
            ->set('email', $this->faker->email)
            ->set('password', 'password123')
            ->set('password_confirmation', 'different_password')
            ->call('save')
            ->assertHasErrors(['password']);
    }

    /** @test */
    public function can_assign_multiple_roles_to_user()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $userRole = Role::where('name', 'user')->first();

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'selectedRoles' => [$managerRole->id, $userRole->id],
        ];

        Livewire::test(UserBasicDataForm::class, ['user' => new User()])
            ->set('name', $userData['name'])
            ->set('email', $userData['email'])
            ->set('password', $userData['password'])
            ->set('password_confirmation', $userData['password_confirmation'])
            ->set('selectedRoles', $userData['selectedRoles'])
            ->call('save');

        $newUser = User::where('email', $userData['email'])->first();
        $this->assertTrue($newUser->hasRole('user'));
        $this->assertTrue($newUser->hasRole('manager'));
    }

    /** @test */
    public function non_admin_cannot_assign_admin_role()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $userRole = Role::where('name', 'user')->first();

        // Create manager user
        $manager = User::factory()->create();
        $manager->assignRole('manager');

        $this->actingAs($manager);

        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'selectedRoles' => [$adminRole->id, $userRole->id],
        ];

        Livewire::test(UserBasicDataForm::class, ['user' => new User()])
            ->set('name', $userData['name'])
            ->set('email', $userData['email'])
            ->set('password', $userData['password'])
            ->set('password_confirmation', $userData['password_confirmation'])
            ->set('selectedRoles', $userData['selectedRoles'])
            ->call('save');

        $newUser = User::where('email', $userData['email'])->first();
        $this->assertTrue($newUser->hasRole('user'));
        $this->assertFalse($newUser->hasRole('admin'));
    }

    /** @test */
    public function user_role_is_always_assigned()
    {
        $managerRole = Role::where('name', 'manager')->first();
        $userRole = Role::where('name', 'user')->first();

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'selectedRoles' => [$managerRole->id], // Não incluindo a role user
        ];

        Livewire::test(UserBasicDataForm::class, ['user' => new User()])
            ->set('name', $userData['name'])
            ->set('email', $userData['email'])
            ->set('password', $userData['password'])
            ->set('password_confirmation', $userData['password_confirmation'])
            ->set('selectedRoles', $userData['selectedRoles'])
            ->call('save');

        $newUser = User::where('email', $userData['email'])->first();
        $this->assertTrue($newUser->hasRole('user'));
        $this->assertTrue($newUser->hasRole('manager'));
    }
}
