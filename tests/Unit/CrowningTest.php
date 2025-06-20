<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Crowning;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrowningTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_crowning()
    {
        $user = User::factory()->create();

        $crowning = Crowning::factory()->create([
            'user_id' => $user->id,
            'start_date' => '2025-01-15',
            'end_date' => '2025-06-15',
            'guide_name' => 'Caboclo Sete Flechas',
            'priest_name' => 'Pai João',
            'temple_name' => 'Templo Luz Divina'
        ]);

        $this->assertDatabaseHas('crownings', [
            'user_id' => $user->id,
            'start_date' => '2025-01-15',
            'end_date' => '2025-06-15',
            'guide_name' => 'Caboclo Sete Flechas',
            'priest_name' => 'Pai João',
            'temple_name' => 'Templo Luz Divina'
        ]);

        $this->assertEquals($user->id, $crowning->user_id);
        $this->assertEquals('2025-01-15', $crowning->start_date);
        $this->assertEquals('2025-06-15', $crowning->end_date);
        $this->assertEquals('Caboclo Sete Flechas', $crowning->guide_name);
        $this->assertEquals('Pai João', $crowning->priest_name);
        $this->assertEquals('Templo Luz Divina', $crowning->temple_name);
    }

    public function test_can_update_crowning()
    {
        $crowning = Crowning::factory()->create();

        $crowning->update([
            'end_date' => '2025-06-20',
            'guide_name' => 'Caboclo Pena Branca',
            'temple_name' => 'Templo Estrela do Oriente'
        ]);

        $this->assertDatabaseHas('crownings', [
            'id' => $crowning->id,
            'end_date' => '2025-06-20',
            'guide_name' => 'Caboclo Pena Branca',
            'temple_name' => 'Templo Estrela do Oriente'
        ]);
    }

    public function test_can_delete_crowning()
    {
        $crowning = Crowning::factory()->create();
        $id = $crowning->id;

        $crowning->delete();

        $this->assertDatabaseMissing('crownings', [
            'id' => $id
        ]);
    }

    public function test_has_user_relationship()
    {
        $user = User::factory()->create();
        $crowning = Crowning::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $crowning->user->id);
        $this->assertInstanceOf(User::class, $crowning->user);
    }    public function test_factory_states()
    {
        $completedCrowning = Crowning::factory()->completed()->create();
        $recentCrowning = Crowning::factory()->recent()->create();

        $this->assertNotNull($completedCrowning->start_date);
        $this->assertNotNull($completedCrowning->end_date);

        $this->assertNotNull($recentCrowning->start_date);
        $this->assertNotNull($recentCrowning->end_date);

        // Data de início do recent deve ser nos últimos 3 meses
        $recentStartDate = new \DateTime($recentCrowning->start_date);
        $threeMonthsAgo = new \DateTime('-3 months');
        $this->assertTrue($recentStartDate >= $threeMonthsAgo);
    }
}
