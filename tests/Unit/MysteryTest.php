<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Mystery;
use App\Models\InitiatedMystery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MysteryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_mystery()
    {
        $mystery = Mystery::factory()->create([
            'name' => 'Mistério do Fogo',
            'active' => true
        ]);

        $this->assertDatabaseHas('mysteries', [
            'name' => 'Mistério do Fogo',
            'active' => true
        ]);

        $this->assertEquals('Mistério do Fogo', $mystery->name);
        $this->assertTrue($mystery->active);
    }

    public function test_can_update_mystery()
    {
        $mystery = Mystery::factory()->create();

        $mystery->update([
            'name' => 'Mistério Atualizado',
            'active' => false
        ]);

        $this->assertDatabaseHas('mysteries', [
            'id' => $mystery->id,
            'name' => 'Mistério Atualizado',
            'active' => false
        ]);
    }

    public function test_can_delete_mystery()
    {
        $mystery = Mystery::factory()->create();

        $mysteryId = $mystery->id;

        $mystery->delete();

        $this->assertDatabaseMissing('mysteries', [
            'id' => $mysteryId,
        ]);
    }

    public function test_has_many_initiated_mysteries_relationship()
    {
        $mystery = Mystery::factory()->create();
        $user = User::factory()->create();

        $initiatedMystery1 = InitiatedMystery::factory()->create([
            'user_id' => $user->id,
            'mystery_id' => $mystery->id
        ]);

        $initiatedMystery2 = InitiatedMystery::factory()->create([
            'user_id' => $user->id,
            'mystery_id' => $mystery->id
        ]);

        $this->assertCount(2, $mystery->initiatedMysteries);
        $this->assertInstanceOf(InitiatedMystery::class, $mystery->initiatedMysteries->first());
    }

    public function test_factory_inactive_state()
    {
        $mystery = Mystery::factory()->inactive()->create();
        $this->assertFalse($mystery->active);
    }
}
