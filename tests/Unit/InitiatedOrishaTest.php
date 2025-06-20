<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Orisha;
use App\Models\InitiatedOrisha;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InitiatedOrishaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_initiated_orisha()
    {
        $user = User::factory()->create();
        $orisha = Orisha::factory()->create();

        $initiatedOrisha = InitiatedOrisha::factory()->create([
            'user_id' => $user->id,
            'orisha_id' => $orisha->id,
            'initiated' => true,
            'observations' => 'Iniciação completa'
        ]);

        $this->assertDatabaseHas('initiated_orishas', [
            'user_id' => $user->id,
            'orisha_id' => $orisha->id,
            'initiated' => true,
            'observations' => 'Iniciação completa'
        ]);

        $this->assertEquals($user->id, $initiatedOrisha->user_id);
        $this->assertEquals($orisha->id, $initiatedOrisha->orisha_id);
        $this->assertTrue($initiatedOrisha->initiated);
        $this->assertEquals('Iniciação completa', $initiatedOrisha->observations);
    }

    public function test_can_update_initiated_orisha()
    {
        $initiatedOrisha = InitiatedOrisha::factory()->create();

        $initiatedOrisha->update([
            'initiated' => false,
            'observations' => 'Iniciação em andamento'
        ]);

        $this->assertDatabaseHas('initiated_orishas', [
            'id' => $initiatedOrisha->id,
            'initiated' => false,
            'observations' => 'Iniciação em andamento'
        ]);
    }

    public function test_belongs_to_user_relationship()
    {
        $user = User::factory()->create();
        $initiatedOrisha = InitiatedOrisha::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(User::class, $initiatedOrisha->user);
        $this->assertEquals($user->id, $initiatedOrisha->user->id);
    }

    public function test_belongs_to_orisha_relationship()
    {
        $orisha = Orisha::factory()->create();
        $initiatedOrisha = InitiatedOrisha::factory()->create([
            'orisha_id' => $orisha->id
        ]);

        $this->assertInstanceOf(Orisha::class, $initiatedOrisha->orisha);
        $this->assertEquals($orisha->id, $initiatedOrisha->orisha->id);
    }

    public function test_factory_initiated_state()
    {
        $initiatedOrisha = InitiatedOrisha::factory()->initiated()->create();
        $this->assertTrue($initiatedOrisha->initiated);
    }

    public function test_factory_not_initiated_state()
    {
        $initiatedOrisha = InitiatedOrisha::factory()->notInitiated()->create();
        $this->assertFalse($initiatedOrisha->initiated);
    }
}
