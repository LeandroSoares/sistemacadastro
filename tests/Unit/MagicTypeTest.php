<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\MagicType;
use App\Models\DivineMagic;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MagicTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_magic_type()
    {
        $magicType = MagicType::factory()->create([
            'name' => 'Magia do Fogo',
            'active' => true
        ]);

        $this->assertDatabaseHas('magic_types', [
            'name' => 'Magia do Fogo',
            'active' => 1
        ]);

        $this->assertEquals('Magia do Fogo', $magicType->name);
        $this->assertTrue($magicType->active);
    }

    public function test_can_update_magic_type()
    {
        $magicType = MagicType::factory()->create(['active' => true]);

        $magicType->update([
            'name' => 'Magia das Pedras',
            'active' => false
        ]);

        $this->assertDatabaseHas('magic_types', [
            'id' => $magicType->id,
            'name' => 'Magia das Pedras',
            'active' => 0
        ]);
    }

    public function test_can_delete_magic_type()
    {
        $magicType = MagicType::factory()->create();
        $id = $magicType->id;

        $magicType->delete();

        $this->assertDatabaseMissing('magic_types', [
            'id' => $id
        ]);
    }

    public function test_has_divine_magics_relationship()
    {
        $magicType = MagicType::factory()->create();

        DivineMagic::factory()->count(3)->create([
            'magic_type_id' => $magicType->id
        ]);

        $this->assertCount(3, $magicType->divineMagics);
        $this->assertInstanceOf(DivineMagic::class, $magicType->divineMagics->first());
    }

    public function test_factory_states()
    {
        $activeType = MagicType::factory()->active()->create();
        $inactiveType = MagicType::factory()->inactive()->create();

        $this->assertTrue($activeType->active);
        $this->assertFalse($inactiveType->active);
    }
}
