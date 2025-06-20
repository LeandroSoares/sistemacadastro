<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\MagicType;
use App\Models\DivineMagic;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DivineMagicTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_divine_magic()
    {
        $user = User::factory()->create();
        $magicType = MagicType::factory()->create();

        $divineMagic = DivineMagic::factory()->create([
            'user_id' => $user->id,
            'magic_type_id' => $magicType->id,
            'date' => '2025-06-15',
            'performed' => true,
            'observations' => 'Teste de magia completo'
        ]);

        $this->assertDatabaseHas('divine_magics', [
            'user_id' => $user->id,
            'magic_type_id' => $magicType->id,
            'date' => '2025-06-15',
            'performed' => 1,
            'observations' => 'Teste de magia completo'
        ]);

        $this->assertEquals($user->id, $divineMagic->user_id);
        $this->assertEquals($magicType->id, $divineMagic->magic_type_id);
        $this->assertEquals('2025-06-15', $divineMagic->date);
        $this->assertTrue($divineMagic->performed);
    }

    public function test_can_update_divine_magic()
    {
        $divineMagic = DivineMagic::factory()->create(['performed' => false]);

        $divineMagic->update([
            'performed' => true,
            'date' => '2025-06-20',
            'observations' => 'Observações atualizadas'
        ]);

        $this->assertDatabaseHas('divine_magics', [
            'id' => $divineMagic->id,
            'performed' => 1,
            'date' => '2025-06-20',
            'observations' => 'Observações atualizadas'
        ]);
    }

    public function test_can_delete_divine_magic()
    {
        $divineMagic = DivineMagic::factory()->create();
        $id = $divineMagic->id;

        $divineMagic->delete();

        $this->assertDatabaseMissing('divine_magics', [
            'id' => $id
        ]);
    }

    public function test_has_user_relationship()
    {
        $user = User::factory()->create();
        $divineMagic = DivineMagic::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $divineMagic->user->id);
        $this->assertInstanceOf(User::class, $divineMagic->user);
    }

    public function test_has_magic_type_relationship()
    {
        $magicType = MagicType::factory()->create(['name' => 'Magia dos Anjos']);
        $divineMagic = DivineMagic::factory()->create(['magic_type_id' => $magicType->id]);

        $this->assertEquals($magicType->id, $divineMagic->magicType->id);
        $this->assertEquals('Magia dos Anjos', $divineMagic->magicType->name);
        $this->assertInstanceOf(MagicType::class, $divineMagic->magicType);
    }

    public function test_factory_states()
    {
        $performed = DivineMagic::factory()->performed()->create();
        $notPerformed = DivineMagic::factory()->notPerformed()->create();

        $this->assertTrue($performed->performed);
        $this->assertFalse($notPerformed->performed);
    }
}
