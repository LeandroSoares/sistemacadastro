<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Orisha;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrishaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_orisha()
    {
        $orisha = Orisha::factory()->create([
            'name' => 'Teste Orixá',
            'description' => 'Descrição de teste',
            'is_right' => true,
            'is_left' => false,
        ]);

        $this->assertDatabaseHas('orishas', [
            'name' => 'Teste Orixá',
            'description' => 'Descrição de teste',
        ]);

        $this->assertEquals('Teste Orixá', $orisha->name);
        $this->assertEquals('Descrição de teste', $orisha->description);
        $this->assertTrue($orisha->is_right);
        $this->assertFalse($orisha->is_left);
        $this->assertTrue($orisha->active);
    }

    public function test_can_update_orisha()
    {
        $orisha = Orisha::factory()->create();

        $orisha->update([
            'name' => 'Orixá Atualizado',
            'description' => 'Nova descrição',
        ]);

        $this->assertDatabaseHas('orishas', [
            'id' => $orisha->id,
            'name' => 'Orixá Atualizado',
            'description' => 'Nova descrição',
        ]);
    }

    public function test_can_delete_orisha()
    {
        $orisha = Orisha::factory()->create();

        $orishaId = $orisha->id;

        $orisha->delete();

        $this->assertDatabaseMissing('orishas', [
            'id' => $orishaId,
        ]);
    }

    public function test_can_create_inactive_orisha()
    {
        $orisha = Orisha::factory()->inactive()->create();

        $this->assertFalse($orisha->active);
    }

    public function test_can_create_right_side_orisha()
    {
        $orisha = Orisha::factory()->rightSide()->create();

        $this->assertTrue($orisha->is_right);
        $this->assertFalse($orisha->is_left);
    }

    public function test_can_create_left_side_orisha()
    {
        $orisha = Orisha::factory()->leftSide()->create();

        $this->assertFalse($orisha->is_right);
        $this->assertTrue($orisha->is_left);
    }
}
