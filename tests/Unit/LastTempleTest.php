<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\LastTemple;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LastTempleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_last_temple()
    {
        $user = User::factory()->create();

        $lastTemple = LastTemple::factory()->create([
            'user_id' => $user->id,
            'name' => 'Templo Luz Divina',
            'address' => 'Rua das Flores, 123',
            'leader_name' => 'João da Silva',
            'function' => 'Médium',
            'exit_reason' => 'Mudança de cidade'
        ]);

        $this->assertDatabaseHas('last_temples', [
            'user_id' => $user->id,
            'name' => 'Templo Luz Divina',
            'address' => 'Rua das Flores, 123',
            'leader_name' => 'João da Silva',
            'function' => 'Médium',
            'exit_reason' => 'Mudança de cidade'
        ]);

        $this->assertEquals($user->id, $lastTemple->user_id);
        $this->assertEquals('Templo Luz Divina', $lastTemple->name);
        $this->assertEquals('João da Silva', $lastTemple->leader_name);
    }

    public function test_can_update_last_temple()
    {
        $lastTemple = LastTemple::factory()->create();

        $lastTemple->update([
            'name' => 'Templo Estrela do Oriente',
            'leader_name' => 'Maria Souza',
            'function' => 'Ogã'
        ]);

        $this->assertDatabaseHas('last_temples', [
            'id' => $lastTemple->id,
            'name' => 'Templo Estrela do Oriente',
            'leader_name' => 'Maria Souza',
            'function' => 'Ogã'
        ]);
    }

    public function test_can_delete_last_temple()
    {
        $lastTemple = LastTemple::factory()->create();
        $id = $lastTemple->id;

        $lastTemple->delete();

        $this->assertDatabaseMissing('last_temples', [
            'id' => $id
        ]);
    }

    public function test_has_user_relationship()
    {
        $user = User::factory()->create();
        $lastTemple = LastTemple::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $lastTemple->user->id);
        $this->assertInstanceOf(User::class, $lastTemple->user);
    }

    public function test_factory_states()
    {
        $minimalTemple = LastTemple::factory()->minimal()->create();

        $this->assertNotNull($minimalTemple->name);
        $this->assertNotNull($minimalTemple->leader_name);
        $this->assertNotNull($minimalTemple->function);
        $this->assertNull($minimalTemple->exit_reason);
        $this->assertEquals('Médium', $minimalTemple->function);
    }
}
