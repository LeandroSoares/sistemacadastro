<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\LastTemple;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\LastTempleForm;

class LastTempleFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function last_temple_form_can_be_rendered()
    {
        $user = User::factory()->create();

        Livewire::test(LastTempleForm::class, ['user' => $user])
            ->assertStatus(200)
            ->assertViewIs('livewire.last-temple-form');
    }

    /** @test */
    public function last_temple_form_shows_existing_data_when_available()
    {
        $user = User::factory()->create();

        $lastTempleData = [
            'user_id' => $user->id,
            'name' => 'Templo Test',
            'address' => 'Rua dos Testes, 123',
            'leader_name' => 'Líder Teste',
            'function' => 'Função Teste',
            'exit_reason' => 'Motivo Teste'
        ];

        $lastTemple = LastTemple::create($lastTempleData);

        Livewire::test(LastTempleForm::class, ['user' => $user])
            ->assertSet('name', 'Templo Test')
            ->assertSet('address', 'Rua dos Testes, 123')
            ->assertSet('leader_name', 'Líder Teste')
            ->assertSet('function', 'Função Teste')
            ->assertSet('exit_reason', 'Motivo Teste');
    }

    /** @test */
    public function last_temple_can_be_saved()
    {
        $user = User::factory()->create();

        Livewire::test(LastTempleForm::class, ['user' => $user])
            ->set('name', 'Novo Templo')
            ->set('address', 'Nova Rua, 456')
            ->set('leader_name', 'Novo Líder')
            ->set('function', 'Nova Função')
            ->set('exit_reason', 'Novo Motivo')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('profile-updated');

        $this->assertDatabaseHas('last_temples', [
            'user_id' => $user->id,
            'name' => 'Novo Templo',
            'address' => 'Nova Rua, 456',
            'leader_name' => 'Novo Líder',
            'function' => 'Nova Função',
            'exit_reason' => 'Novo Motivo'
        ]);
    }

    /** @test */
    public function last_temple_can_be_updated()
    {
        $user = User::factory()->create();

        $lastTemple = LastTemple::create([
            'user_id' => $user->id,
            'name' => 'Templo Original',
            'address' => 'Endereço Original',
            'leader_name' => 'Líder Original',
            'function' => 'Função Original',
            'exit_reason' => 'Motivo Original'
        ]);

        Livewire::test(LastTempleForm::class, ['user' => $user])
            ->set('name', 'Templo Atualizado')
            ->set('address', 'Endereço Atualizado')
            ->set('leader_name', 'Líder Atualizado')
            ->set('function', 'Função Atualizada')
            ->set('exit_reason', 'Motivo Atualizado')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('profile-updated');

        $this->assertDatabaseHas('last_temples', [
            'user_id' => $user->id,
            'name' => 'Templo Atualizado',
            'address' => 'Endereço Atualizado',
            'leader_name' => 'Líder Atualizado',
            'function' => 'Função Atualizada',
            'exit_reason' => 'Motivo Atualizado'
        ]);
    }

    /** @test */
    public function last_temple_fields_can_be_nullable()
    {
        $user = User::factory()->create();

        Livewire::test(LastTempleForm::class, ['user' => $user])
            ->set('name', '')
            ->set('address', '')
            ->set('leader_name', '')
            ->set('function', '')
            ->set('exit_reason', '')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('profile-updated');

        $this->assertDatabaseHas('last_temples', [
            'user_id' => $user->id,
            'name' => null,
            'address' => null,
            'leader_name' => null,
            'function' => null,
            'exit_reason' => null
        ]);
    }
}
