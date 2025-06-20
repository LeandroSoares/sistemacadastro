<?php

namespace Tests\Feature;

use App\Livewire\InitiatedMysteryForm;
use App\Models\Mystery;
use App\Models\InitiatedMystery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class InitiatedMysteryFormTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $mystery;

    public function setUp(): void
    {
        parent::setUp();

        $this->mystery = Mystery::create([
            'name' => 'Mistério de Teste',
            'description' => 'Descrição do mistério de teste',
            'active' => true
        ]);
    }

    /** @test */
    public function component_can_render()
    {
        $user = User::factory()->create();

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user])
            ->assertViewIs('livewire.initiated-mystery-form');
    }

    /** @test */
    public function can_register_initiated_mystery()
    {
        $user = User::factory()->create();

        $data = [
            'mystery_id' => $this->mystery->id,
            'date' => now()->format('Y-m-d'),
            'completed' => true,
            'observations' => 'Observações de teste'
        ];

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user])
            ->set('mystery_id', $data['mystery_id'])
            ->set('date', $data['date'])
            ->set('completed', $data['completed'])
            ->set('observations', $data['observations'])
            ->call('save')
            ->assertDispatched('profile-updated');

        $this->assertDatabaseHas('initiated_mysteries', [
            'user_id' => $user->id,
            'mystery_id' => $data['mystery_id'],
            'completed' => $data['completed'],
            'observations' => $data['observations'],
        ]);
    }

    /** @test */
    public function can_edit_initiated_mystery()
    {
        $user = User::factory()->create();
        $initiatedMystery = InitiatedMystery::create([
            'user_id' => $user->id,
            'mystery_id' => $this->mystery->id,
            'date' => now()->subDays(5),
            'completed' => false,
            'observations' => 'Observações originais'
        ]);

        $newData = [
            'completed' => true,
            'observations' => 'Observações atualizadas',
            'date' => now()->format('Y-m-d')
        ];

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user])
            ->call('editMystery', $initiatedMystery->id)
            ->assertSet('editing', true)
            ->assertSet('editingMysteryId', $initiatedMystery->id)
            ->assertSet('mystery_id', $this->mystery->id)
            ->set('completed', $newData['completed'])
            ->set('observations', $newData['observations'])
            ->set('date', $newData['date'])
            ->call('save');

        $this->assertDatabaseHas('initiated_mysteries', [
            'id' => $initiatedMystery->id,
            'completed' => $newData['completed'],
            'observations' => $newData['observations'],
        ]);
    }

    /** @test */
    public function can_cancel_edit()
    {
        $user = User::factory()->create();
        $initiatedMystery = InitiatedMystery::create([
            'user_id' => $user->id,
            'mystery_id' => $this->mystery->id,
            'date' => now()->subDays(5),
            'completed' => false,
            'observations' => 'Observações originais'
        ]);

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user])
            ->call('editMystery', $initiatedMystery->id)
            ->assertSet('editing', true)
            ->call('cancelEdit')
            ->assertSet('editing', false)
            ->assertSet('editingMysteryId', null)
            ->assertSet('mystery_id', '')
            ->assertSet('observations', '');
    }

    /** @test */
    public function can_delete_initiated_mystery()
    {
        $user = User::factory()->create();
        $initiatedMystery = InitiatedMystery::create([
            'user_id' => $user->id,
            'mystery_id' => $this->mystery->id,
            'date' => now()->subDays(5),
            'completed' => false,
            'observations' => 'Observações para excluir'
        ]);

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user])
            ->call('deleteMystery', $initiatedMystery->id);

        $this->assertModelMissing($initiatedMystery);
    }

    /** @test */
    public function cannot_edit_mystery_of_different_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $initiatedMystery = InitiatedMystery::create([
            'user_id' => $user2->id,
            'mystery_id' => $this->mystery->id,
            'date' => now()->subDays(5),
            'completed' => false,
            'observations' => 'Observações de outro usuário'
        ]);

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user1])
            ->call('editMystery', $initiatedMystery->id)
            ->assertSet('editing', false)
            ->assertSet('mystery_id', '')
            ->assertSet('observations', '');
    }

    /** @test */
    public function cannot_delete_mystery_of_different_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $initiatedMystery = InitiatedMystery::create([
            'user_id' => $user2->id,
            'mystery_id' => $this->mystery->id,
            'date' => now()->subDays(5),
            'completed' => false,
            'observations' => 'Observações de outro usuário'
        ]);

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user1])
            ->call('deleteMystery', $initiatedMystery->id);

        $this->assertModelExists($initiatedMystery);
    }

    /** @test */
    public function validates_required_fields()
    {
        $user = User::factory()->create();

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user])
            ->set('mystery_id', '')
            ->call('save')
            ->assertHasErrors(['mystery_id']);
    }

    /** @test */
    public function validates_mystery_exists()
    {
        $user = User::factory()->create();

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user])
            ->set('mystery_id', 999) // ID inexistente
            ->set('date', now()->format('Y-m-d'))
            ->set('observations', 'Observação teste')
            ->call('save')
            ->assertHasErrors(['mystery_id']);
    }

    /** @test */
    public function initiated_mysteries_are_ordered_by_date_desc()
    {
        $user = User::factory()->create();

        $mystery2 = Mystery::create([
            'name' => 'Segundo Mistério',
            'description' => 'Descrição do segundo mistério',
            'active' => true
        ]);

        $oldMystery = InitiatedMystery::create([
            'user_id' => $user->id,
            'mystery_id' => $this->mystery->id,
            'date' => now()->subDays(10),
            'completed' => true,
            'observations' => 'Observações antigas'
        ]);

        $newMystery = InitiatedMystery::create([
            'user_id' => $user->id,
            'mystery_id' => $mystery2->id,
            'date' => now()->subDays(5),
            'completed' => false,
            'observations' => 'Observações recentes'
        ]);

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user])
            ->assertViewHas('mysteries', function ($mysteries) use ($newMystery) {
                return $mysteries->first()->id === $newMystery->id;
            });
    }

    /** @test */
    public function fields_reset_after_save()
    {
        $user = User::factory()->create();

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user])
            ->set('mystery_id', $this->mystery->id)
            ->set('date', now()->format('Y-m-d'))
            ->set('completed', true)
            ->set('observations', 'Observações de teste')
            ->call('save')
            ->assertSet('mystery_id', '')
            ->assertSet('date', '')
            ->assertSet('completed', false)
            ->assertSet('observations', '');
    }

    /** @test */
    public function only_active_mysteries_are_available()
    {
        $user = User::factory()->create();

        $inactiveMystery = Mystery::create([
            'name' => 'Mistério Inativo',
            'description' => 'Este mistério está inativo',
            'active' => false
        ]);

        Livewire::test(InitiatedMysteryForm::class, ['user' => $user])
            ->assertViewHas('availableMysteries', function ($mysteries) use ($inactiveMystery) {
                return $mysteries->contains('id', $this->mystery->id) &&
                       !$mysteries->contains('id', $inactiveMystery->id);
            });
    }
}
