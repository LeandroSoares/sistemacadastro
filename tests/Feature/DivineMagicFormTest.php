<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\MagicType;
use App\Models\DivineMagic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\DivineMagicForm;

class DivineMagicFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function divine_magic_form_can_be_rendered()
    {
        $user = User::factory()->create();

        Livewire::test(DivineMagicForm::class, ['user' => $user])
            ->assertStatus(200)
            ->assertViewIs('livewire.divine-magic-form');
    }

    /** @test */
    public function magic_types_are_loaded()
    {
        $user = User::factory()->create();

        // Criar tipos de magia para teste
        $magicType1 = MagicType::create([
            'name' => 'Magia do Fogo',
            'active' => true
        ]);

        $magicType2 = MagicType::create([
            'name' => 'Magia das Pedras',
            'active' => true
        ]);

        $inactiveMagicType = MagicType::create([
            'name' => 'Magia Inativa',
            'active' => false
        ]);

        Livewire::test(DivineMagicForm::class, ['user' => $user])
            ->assertSee('Magia do Fogo')
            ->assertSee('Magia das Pedras')
            ->assertDontSee('Magia Inativa');
    }

    /** @test */
    public function can_add_divine_magic()
    {
        $user = User::factory()->create();

        $magicType = MagicType::create([
            'name' => 'Magia do Fogo',
            'active' => true
        ]);

        $date = '2025-01-15';

        Livewire::test(DivineMagicForm::class, ['user' => $user])
            ->set('magic_type_id', $magicType->id)
            ->set('date', $date)
            ->set('performed', true)
            ->set('observations', 'Teste de observações')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSet('magic_type_id', '')
            ->assertSet('date', '')
            ->assertSet('performed', false)
            ->assertSet('observations', '')
            ->assertSee('Magia divina registrada com sucesso');

        $this->assertDatabaseHas('divine_magics', [
            'user_id' => $user->id,
            'magic_type_id' => $magicType->id,
            'date' => $date,
            'performed' => true,
            'observations' => 'Teste de observações'
        ]);
    }

    /** @test */
    public function can_edit_divine_magic()
    {
        $user = User::factory()->create();

        $magicType = MagicType::create([
            'name' => 'Magia do Fogo',
            'active' => true
        ]);

        $divineMagic = DivineMagic::create([
            'user_id' => $user->id,
            'magic_type_id' => $magicType->id,
            'date' => '2025-01-01',
            'performed' => false,
            'observations' => 'Observação original'
        ]);

        Livewire::test(DivineMagicForm::class, ['user' => $user])
            ->call('editMagic', $divineMagic->id)
            ->assertSet('editing', true)
            ->assertSet('editingMagicId', $divineMagic->id)
            ->assertSet('magic_type_id', $magicType->id)
            ->assertSet('date', '2025-01-01')
            ->assertSet('performed', false)
            ->assertSet('observations', 'Observação original')
            ->set('date', '2025-01-15')
            ->set('performed', true)
            ->set('observations', 'Observação atualizada')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Magia divina atualizada com sucesso');

        $this->assertDatabaseHas('divine_magics', [
            'id' => $divineMagic->id,
            'user_id' => $user->id,
            'magic_type_id' => $magicType->id,
            'date' => '2025-01-15',
            'performed' => true,
            'observations' => 'Observação atualizada'
        ]);
    }

    /** @test */
    public function can_cancel_edit()
    {
        $user = User::factory()->create();

        $magicType = MagicType::create([
            'name' => 'Magia do Fogo',
            'active' => true
        ]);

        $divineMagic = DivineMagic::create([
            'user_id' => $user->id,
            'magic_type_id' => $magicType->id,
            'date' => '2025-01-01',
            'performed' => false,
            'observations' => 'Observação original'
        ]);

        Livewire::test(DivineMagicForm::class, ['user' => $user])
            ->call('editMagic', $divineMagic->id)
            ->assertSet('editing', true)
            ->call('cancelEdit')
            ->assertSet('editing', false)
            ->assertSet('editingMagicId', null)
            ->assertSet('magic_type_id', '')
            ->assertSet('date', '')
            ->assertSet('performed', false)
            ->assertSet('observations', '');
    }

    /** @test */
    public function can_delete_divine_magic()
    {
        $user = User::factory()->create();

        $magicType = MagicType::create([
            'name' => 'Magia do Fogo',
            'active' => true
        ]);

        $divineMagic = DivineMagic::create([
            'user_id' => $user->id,
            'magic_type_id' => $magicType->id,
            'date' => '2025-01-01',
            'performed' => false,
            'observations' => 'Observação'
        ]);

        $this->assertDatabaseCount('divine_magics', 1);

        Livewire::test(DivineMagicForm::class, ['user' => $user])
            ->call('deleteMagic', $divineMagic->id)
            ->assertSee('Magia divina removida com sucesso');

        $this->assertDatabaseCount('divine_magics', 0);
        $this->assertDatabaseMissing('divine_magics', [
            'id' => $divineMagic->id
        ]);
    }

    /** @test */
    public function cannot_delete_another_users_magic()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $magicType = MagicType::create([
            'name' => 'Magia do Fogo',
            'active' => true
        ]);

        $divineMagic = DivineMagic::create([
            'user_id' => $user2->id,
            'magic_type_id' => $magicType->id,
            'date' => '2025-01-01',
            'performed' => false,
            'observations' => 'Observação'
        ]);

        $this->assertDatabaseCount('divine_magics', 1);

        Livewire::test(DivineMagicForm::class, ['user' => $user1])
            ->call('deleteMagic', $divineMagic->id);

        $this->assertDatabaseCount('divine_magics', 1);
        $this->assertDatabaseHas('divine_magics', [
            'id' => $divineMagic->id
        ]);
    }
}
