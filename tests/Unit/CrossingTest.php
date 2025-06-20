<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Crossing;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrossingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_crossing()
    {
        $user = User::factory()->create();

        $crossing = Crossing::factory()->create([
            'user_id' => $user->id,
            'entity' => 'Exu Guardião',
            'date' => '2025-01-15',
            'purpose' => 'Proteção espiritual'
        ]);

        $this->assertDatabaseHas('crossings', [
            'user_id' => $user->id,
            'entity' => 'Exu Guardião',
            'date' => '2025-01-15',
            'purpose' => 'Proteção espiritual'
        ]);

        $this->assertEquals($user->id, $crossing->user_id);
        $this->assertEquals('Exu Guardião', $crossing->entity);
        $this->assertEquals('2025-01-15', $crossing->date);
        $this->assertEquals('Proteção espiritual', $crossing->purpose);
    }

    public function test_can_update_crossing()
    {
        $crossing = Crossing::factory()->create();

        $crossing->update([
            'entity' => 'Pombagira',
            'date' => '2025-02-20',
            'purpose' => 'Novo propósito'
        ]);

        $this->assertDatabaseHas('crossings', [
            'id' => $crossing->id,
            'entity' => 'Pombagira',
            'date' => '2025-02-20',
            'purpose' => 'Novo propósito'
        ]);
    }

    public function test_can_delete_crossing()
    {
        $crossing = Crossing::factory()->create();

        $crossingId = $crossing->id;

        $crossing->delete();

        $this->assertDatabaseMissing('crossings', [
            'id' => $crossingId,
        ]);
    }

    public function test_belongs_to_user_relationship()
    {
        $user = User::factory()->create();
        $crossing = Crossing::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(User::class, $crossing->user);
        $this->assertEquals($user->id, $crossing->user->id);
    }

    public function test_factory_for_entity_state()
    {
        $crossing = Crossing::factory()->forEntity('Caboclo')->create();

        $this->assertEquals('Caboclo', $crossing->entity);
    }
}
