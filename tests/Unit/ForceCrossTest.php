<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\ForceCross;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForceCrossTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_force_cross()
    {
        $user = User::factory()->create();

        $forceCross = ForceCross::factory()->create([
            'user_id' => $user->id,
            'top' => 'Oxalá',
            'bottom' => 'Omulu',
            'left' => 'Ogum',
            'right' => 'Xangô'
        ]);

        $this->assertDatabaseHas('force_crosses', [
            'user_id' => $user->id,
            'top' => 'Oxalá',
            'bottom' => 'Omulu',
            'left' => 'Ogum',
            'right' => 'Xangô'
        ]);

        $this->assertEquals($user->id, $forceCross->user_id);
        $this->assertEquals('Oxalá', $forceCross->top);
        $this->assertEquals('Omulu', $forceCross->bottom);
        $this->assertEquals('Ogum', $forceCross->left);
        $this->assertEquals('Xangô', $forceCross->right);
    }

    public function test_can_update_force_cross()
    {
        $forceCross = ForceCross::factory()->create();

        $forceCross->update([
            'top' => 'Oxum',
            'bottom' => 'Nanã',
            'left' => 'Iemanjá',
            'right' => 'Iansã'
        ]);

        $this->assertDatabaseHas('force_crosses', [
            'id' => $forceCross->id,
            'top' => 'Oxum',
            'bottom' => 'Nanã',
            'left' => 'Iemanjá',
            'right' => 'Iansã'
        ]);
    }

    public function test_can_delete_force_cross()
    {
        $forceCross = ForceCross::factory()->create();
        $id = $forceCross->id;

        $forceCross->delete();

        $this->assertDatabaseMissing('force_crosses', [
            'id' => $id
        ]);
    }

    public function test_has_user_relationship()
    {
        $user = User::factory()->create();
        $forceCross = ForceCross::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $forceCross->user->id);
        $this->assertInstanceOf(User::class, $forceCross->user);
    }

    public function test_calculates_completion_rate()
    {
        // Teste com cruz completa (100%)
        $completeCross = ForceCross::factory()->create([
            'top' => 'Oxalá',
            'bottom' => 'Omulu',
            'left' => 'Ogum',
            'right' => 'Xangô'
        ]);
        $this->assertEquals(100, $completeCross->getCompletionRate());

        // Teste com cruz com valores padrões (100%)
        $defaultCross = ForceCross::factory()->minimal()->create();
        $this->assertEquals(100, $defaultCross->getCompletionRate());
    }

    public function test_factory_states()
    {
        $completeCross = ForceCross::factory()->complete()->create();
        $minimalCross = ForceCross::factory()->minimal()->create();

        // Completo
        $this->assertNotNull($completeCross->top);
        $this->assertNotNull($completeCross->bottom);
        $this->assertNotNull($completeCross->left);
        $this->assertNotNull($completeCross->right);

        // Minimal
        $this->assertEquals('Desconhecido', $minimalCross->top);
        $this->assertEquals('Desconhecido', $minimalCross->bottom);
        $this->assertEquals('Desconhecido', $minimalCross->left);
        $this->assertEquals('Desconhecido', $minimalCross->right);
    }
}
