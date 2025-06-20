<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Amaci;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AmaciTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_amaci()
    {
        $user = User::factory()->create();

        $amaci = Amaci::factory()->create([
            'user_id' => $user->id,
            'type' => 'Completo',
            'date' => '2025-05-15',
            'observations' => 'Realizado com ervas sagradas'
        ]);

        $this->assertDatabaseHas('amacis', [
            'user_id' => $user->id,
            'type' => 'Completo',
            'date' => '2025-05-15',
            'observations' => 'Realizado com ervas sagradas'
        ]);

        $this->assertEquals($user->id, $amaci->user_id);
        $this->assertEquals('Completo', $amaci->type);
        $this->assertEquals('2025-05-15', $amaci->date);
        $this->assertEquals('Realizado com ervas sagradas', $amaci->observations);
    }

    public function test_can_update_amaci()
    {
        $amaci = Amaci::factory()->create();

        $amaci->update([
            'type' => 'Cabeça',
            'observations' => 'Observações atualizadas'
        ]);

        $this->assertDatabaseHas('amacis', [
            'id' => $amaci->id,
            'type' => 'Cabeça',
            'observations' => 'Observações atualizadas'
        ]);
    }

    public function test_belongs_to_user_relationship()
    {
        $user = User::factory()->create();
        $amaci = Amaci::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(User::class, $amaci->user);
        $this->assertEquals($user->id, $amaci->user->id);
    }

    public function test_factory_for_head_state()
    {
        $amaci = Amaci::factory()->forHead()->create();
        $this->assertEquals('Cabeça', $amaci->type);
    }

    public function test_factory_for_body_state()
    {
        $amaci = Amaci::factory()->forBody()->create();
        $this->assertEquals('Corpo', $amaci->type);
    }

    public function test_factory_complete_state()
    {
        $amaci = Amaci::factory()->complete()->create();
        $this->assertEquals('Completo', $amaci->type);
    }
}
