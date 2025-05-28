<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Orisha;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrishaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles
        $this->seed(RoleSeeder::class);

        // Create and authenticate a user with admin role
        $this->user = User::factory()->create();
        $this->user->assignRole('admin');
        $this->actingAs($this->user);
    }

    public function test_index_displays_orishas()
    {
        $orisha = Orisha::factory()->create();

        $response = $this->get(route('orishas.index'));

        $response->assertStatus(200)
            ->assertViewIs('orishas.index')
            ->assertSee($orisha->name);
    }

    public function test_create_displays_form()
    {
        $response = $this->get(route('orishas.create'));

        $response->assertStatus(200)
            ->assertViewIs('orishas.create');
    }

    public function test_store_creates_new_orisha()
    {
        $orishaData = [
            'name' => 'Test Orisha',
            'description' => 'Test Description',
            'is_right' => true,
            'is_left' => false,
            'active' => true,
        ];

        $response = $this->post(route('orishas.store'), $orishaData);

        $response->assertRedirect(route('orishas.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('orishas', $orishaData);
    }

    public function test_edit_displays_form()
    {
        $orisha = Orisha::factory()->create();

        $response = $this->get(route('orishas.edit', $orisha));

        $response->assertStatus(200)
            ->assertViewIs('orishas.edit')
            ->assertViewHas('orisha', $orisha);
    }

    public function test_update_modifies_orisha()
    {
        $orisha = Orisha::factory()->create([
            'is_right' => true,
            'is_left' => false,
            'active' => true
        ]);

        $updatedData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_right' => '0',  // Send as string to simulate form data
            'is_left' => '1',   // Send as string to simulate form data
            'active' => '1'     // Send as string to simulate form data
        ];

        $response = $this->put(route('orishas.update', $orisha), $updatedData);

        $response->assertRedirect(route('orishas.index'))
            ->assertSessionHas('success');

        $orisha->refresh();
        $this->assertEquals('Updated Name', $orisha->name);
        $this->assertEquals('Updated Description', $orisha->description);
        $this->assertFalse((bool) $orisha->is_right);
        $this->assertTrue((bool) $orisha->is_left);
        $this->assertTrue((bool) $orisha->active);
    }

    public function test_destroy_deletes_orisha()
    {
        $orisha = Orisha::factory()->create();

        $response = $this->delete(route('orishas.destroy', $orisha));

        $response->assertRedirect(route('orishas.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('orishas', ['id' => $orisha->id]);
    }
}
