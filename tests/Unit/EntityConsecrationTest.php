<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\EntityConsecration;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityConsecrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_entity_consecration()
    {
        $user = User::factory()->create();

        $entityConsecration = EntityConsecration::factory()->create([
            'user_id' => $user->id,
            'entity' => 'Caboclo',
            'name' => 'Caboclo Pena Verde',
            'date' => '2025-05-15'
        ]);

        $this->assertDatabaseHas('entity_consecrations', [
            'user_id' => $user->id,
            'entity' => 'Caboclo',
            'name' => 'Caboclo Pena Verde',
            'date' => '2025-05-15'
        ]);

        $this->assertEquals($user->id, $entityConsecration->user_id);
        $this->assertEquals('Caboclo', $entityConsecration->entity);
        $this->assertEquals('Caboclo Pena Verde', $entityConsecration->name);
        $this->assertEquals('2025-05-15', $entityConsecration->date);
    }

    public function test_can_update_entity_consecration()
    {
        $entityConsecration = EntityConsecration::factory()->create();

        $entityConsecration->update([
            'entity' => 'Exu',
            'name' => 'Exu Tranca Ruas',
            'date' => '2025-06-20'
        ]);

        $this->assertDatabaseHas('entity_consecrations', [
            'id' => $entityConsecration->id,
            'entity' => 'Exu',
            'name' => 'Exu Tranca Ruas',
            'date' => '2025-06-20'
        ]);
    }

    public function test_can_delete_entity_consecration()
    {
        $entityConsecration = EntityConsecration::factory()->create();
        $id = $entityConsecration->id;

        $entityConsecration->delete();

        $this->assertDatabaseMissing('entity_consecrations', [
            'id' => $id
        ]);
    }

    public function test_has_user_relationship()
    {
        $user = User::factory()->create();
        $entityConsecration = EntityConsecration::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $entityConsecration->user->id);
        $this->assertInstanceOf(User::class, $entityConsecration->user);
    }

    public function test_factory_states()
    {
        $caboclo = EntityConsecration::factory()->caboclo()->create();
        $exu = EntityConsecration::factory()->exu()->create();

        $this->assertEquals('Caboclo', $caboclo->entity);
        $this->assertStringContainsString('Caboclo', $caboclo->name);

        $this->assertEquals('Exu', $exu->entity);
        $this->assertStringContainsString('Exu', $exu->name);
    }
}
