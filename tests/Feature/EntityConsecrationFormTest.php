<?php

namespace Tests\Feature;

use App\Livewire\EntityConsecrationForm;
use App\Models\EntityConsecration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EntityConsecrationFormTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function component_can_render()
    {
        $user = User::factory()->create();

        Livewire::test(EntityConsecrationForm::class, ['user' => $user])
            ->assertViewIs('livewire.entity-consecration-form');
    }

    /** @test */
    public function can_create_entity_consecration()
    {
        $user = User::factory()->create();

        $data = [
            'entity' => 'Entidade de Teste',
            'name' => 'Nome da Entidade',
            'date' => now()->format('Y-m-d'),
        ];

        Livewire::test(EntityConsecrationForm::class, ['user' => $user])
            ->set('entity', $data['entity'])
            ->set('name', $data['name'])
            ->set('date', $data['date'])
            ->call('save');

        $this->assertDatabaseHas('entity_consecrations', [
            'user_id' => $user->id,
            'entity' => $data['entity'],
            'name' => $data['name'],
        ]);
    }

    /** @test */
    public function can_edit_entity_consecration()
    {
        $user = User::factory()->create();
        $consecration = EntityConsecration::create([
            'user_id' => $user->id,
            'entity' => 'Entidade Original',
            'name' => 'Nome Original',
            'date' => now()->subDays(5),
        ]);

        $newEntity = 'Entidade Atualizada';
        $newName = 'Nome Atualizado';
        $newDate = now()->format('Y-m-d');

        Livewire::test(EntityConsecrationForm::class, ['user' => $user])
            ->call('editConsecration', $consecration->id)
            ->assertSet('editing', true)
            ->assertSet('editingConsecrationId', $consecration->id)
            ->set('entity', $newEntity)
            ->set('name', $newName)
            ->set('date', $newDate)
            ->call('save');

        $this->assertDatabaseHas('entity_consecrations', [
            'id' => $consecration->id,
            'entity' => $newEntity,
            'name' => $newName,
        ]);
    }

    /** @test */
    public function can_cancel_edit()
    {
        $user = User::factory()->create();
        $consecration = EntityConsecration::create([
            'user_id' => $user->id,
            'entity' => 'Entidade Original',
            'name' => 'Nome Original',
            'date' => now()->subDays(5),
        ]);

        Livewire::test(EntityConsecrationForm::class, ['user' => $user])
            ->call('editConsecration', $consecration->id)
            ->assertSet('editing', true)
            ->call('cancelEdit')
            ->assertSet('editing', false)
            ->assertSet('editingConsecrationId', null)
            ->assertSet('entity', '');
    }

    /** @test */
    public function can_delete_entity_consecration()
    {
        $user = User::factory()->create();
        $consecration = EntityConsecration::create([
            'user_id' => $user->id,
            'entity' => 'Entidade para Excluir',
            'name' => 'Nome para Excluir',
            'date' => now()->subDays(5),
        ]);

        Livewire::test(EntityConsecrationForm::class, ['user' => $user])
            ->call('deleteConsecration', $consecration->id);

        $this->assertModelMissing($consecration);
    }

    /** @test */
    public function cannot_delete_consecration_of_different_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $consecration = EntityConsecration::create([
            'user_id' => $user2->id,
            'entity' => 'Entidade de Outro Usuário',
            'name' => 'Nome',
            'date' => now()->subDays(5),
        ]);

        Livewire::test(EntityConsecrationForm::class, ['user' => $user1])
            ->call('deleteConsecration', $consecration->id);

        $this->assertModelExists($consecration);
    }

    /** @test */
    public function cannot_edit_consecration_of_different_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $consecration = EntityConsecration::create([
            'user_id' => $user2->id,
            'entity' => 'Entidade de Outro Usuário',
            'name' => 'Nome',
            'date' => now()->subDays(5),
        ]);

        Livewire::test(EntityConsecrationForm::class, ['user' => $user1])
            ->call('editConsecration', $consecration->id)
            ->assertSet('editing', false)
            ->assertSet('entity', '');
    }

    /** @test */
    public function validates_required_fields()
    {
        $user = User::factory()->create();

        Livewire::test(EntityConsecrationForm::class, ['user' => $user])
            ->set('entity', '') // entity é obrigatório
            ->call('save')
            ->assertHasErrors(['entity']);
    }

    /** @test */
    public function consecrations_are_displayed_ordered_by_date_desc()
    {
        $user = User::factory()->create();

        $oldConsecration = EntityConsecration::create([
            'user_id' => $user->id,
            'entity' => 'Entidade Antiga',
            'name' => 'Nome Antigo',
            'date' => now()->subDays(10),
        ]);

        $newConsecration = EntityConsecration::create([
            'user_id' => $user->id,
            'entity' => 'Entidade Nova',
            'name' => 'Nome Novo',
            'date' => now()->subDays(5),
        ]);

        Livewire::test(EntityConsecrationForm::class, ['user' => $user])
            ->assertViewHas('consecrations', function ($consecrations) use ($newConsecration) {
                return $consecrations->first()->id === $newConsecration->id;
            });
    }

    /** @test */
    public function fields_reset_after_save()
    {
        $user = User::factory()->create();

        $data = [
            'entity' => 'Entidade de Teste',
            'name' => 'Nome da Entidade',
            'date' => now()->format('Y-m-d'),
        ];

        Livewire::test(EntityConsecrationForm::class, ['user' => $user])
            ->set('entity', $data['entity'])
            ->set('name', $data['name'])
            ->set('date', $data['date'])
            ->call('save')
            ->assertSet('entity', '')
            ->assertSet('name', '')
            ->assertSet('date', '');
    }
}
