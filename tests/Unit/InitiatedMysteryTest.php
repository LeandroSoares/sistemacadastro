<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mystery;
use App\Models\InitiatedMystery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InitiatedMysteryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_initiated_mystery()
    {
        $user = User::factory()->create();
        $mystery = Mystery::factory()->create();

        $initiatedMystery = InitiatedMystery::factory()->create([
            'user_id' => $user->id,
            'mystery_id' => $mystery->id,
            'date' => '2025-06-15',
            'completed' => true,
            'observations' => 'Iniciação realizada com sucesso'
        ]);

        $this->assertDatabaseHas('initiated_mysteries', [
            'user_id' => $user->id,
            'mystery_id' => $mystery->id,
            'date' => '2025-06-15',
            'completed' => true,
            'observations' => 'Iniciação realizada com sucesso'
        ]);

        $this->assertEquals($user->id, $initiatedMystery->user_id);
        $this->assertEquals($mystery->id, $initiatedMystery->mystery_id);
        $this->assertEquals('2025-06-15', $initiatedMystery->date);
        $this->assertTrue($initiatedMystery->completed);
        $this->assertEquals('Iniciação realizada com sucesso', $initiatedMystery->observations);
    }

    public function test_can_update_initiated_mystery()
    {
        $initiatedMystery = InitiatedMystery::factory()->create();

        $initiatedMystery->update([
            'date' => '2025-06-19',
            'completed' => false,
            'observations' => 'Iniciação em andamento'
        ]);

        $this->assertDatabaseHas('initiated_mysteries', [
            'id' => $initiatedMystery->id,
            'date' => '2025-06-19',
            'completed' => false,
            'observations' => 'Iniciação em andamento'
        ]);
    }

    public function test_belongs_to_user_relationship()
    {
        $user = User::factory()->create();
        $initiatedMystery = InitiatedMystery::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(User::class, $initiatedMystery->user);
        $this->assertEquals($user->id, $initiatedMystery->user->id);
    }

    public function test_belongs_to_mystery_relationship()
    {
        $mystery = Mystery::factory()->create();
        $initiatedMystery = InitiatedMystery::factory()->create([
            'mystery_id' => $mystery->id
        ]);

        $this->assertInstanceOf(Mystery::class, $initiatedMystery->mystery);
        $this->assertEquals($mystery->id, $initiatedMystery->mystery->id);
    }

    public function test_factory_completed_state()
    {
        $initiatedMystery = InitiatedMystery::factory()->completed()->create();
        $this->assertTrue($initiatedMystery->completed);
    }
}
