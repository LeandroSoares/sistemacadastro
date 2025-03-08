<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_admin_can_view_users_list()
    {
        $admin = User::factory()->create()->assignRole('admin');
        
        $response = $this->actingAs($admin)->get('/users');
        
        $response->assertStatus(200);
        $response->assertViewIs('users.index');
    }

    public function test_non_admin_cannot_view_users_list()
    {
        $non_admin = User::factory()->create()->assignRole('user');
        
        $response = $this->actingAs($non_admin)->get('/users');
        
        $response->assertStatus(403);
    }

    public function test_admin_can_create_user()
    {
        $admin = User::factory()->create()->assignRole('admin');
        
        $response = $this->actingAs($admin)->get('/users/create');
        
        $response->assertStatus(200);
        $response->assertViewIs('users.create');
    }

    public function test_admin_can_edit_user()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $user = User::factory()->create();
        
        $response = $this->actingAs($admin)->get("/users/{$user->id}/edit");
        
        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
    }

    // public function test_admin_can_update_user()
    // {
    //     $admin = User::factory()->create()->assignRole('admin');
    //     $user = User::factory()->create()->assignRole('user');
        
    //     $response = $this->actingAs($admin)
    //         ->put("/users/{$user->id}", [
    //             'name' => 'Updated Name',
    //             'email' => 'updated@example.com',
    //             'roles' => ['manager']
    //         ]);
        
    //     $response->assertRedirect('/users');
    //     $this->assertDatabaseHas('users', [
    //         'id' => $user->id,
    //         'name' => 'Updated Name',
    //         'email' => 'updated@example.com'
    //     ]);
    // }

    public function test_admin_can_delete_user()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $user = User::factory()->create();
        
        $response = $this->actingAs($admin)->delete("/users/{$user->id}");
        
        $response->assertRedirect('/users');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
