<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Amaci;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\AmaciForm;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AmaciFormTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function amaci_form_saves_and_displays_data()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Dados de teste para amaci
        $amaciData = [
            'type' => 'Cabeça',
            'observations' => 'Realizado com ervas sagradas',
            'date' => '2023-05-15',
        ];

        // Salvar dados através do componente Livewire
        Livewire::test(AmaciForm::class, ['user' => $user])
            ->set('type', $amaciData['type'])
            ->set('observations', $amaciData['observations'])
            ->set('date', $amaciData['date'])
            ->call('save');

        // Verificar se os dados foram salvos no banco
        $this->assertDatabaseHas('amacis', [
            'user_id' => $user->id,
            'type' => $amaciData['type'],
            'observations' => $amaciData['observations'],
            'date' => $amaciData['date'],
        ]);

        // Verificar se a ação foi realizada com sucesso
        Livewire::test(AmaciForm::class, ['user' => $user])
            ->set('type', $amaciData['type'])
            ->set('observations', $amaciData['observations'])
            ->set('date', $amaciData['date'])
            ->call('save')
            ->assertDispatched('profile-updated');
    }

    #[Test]
    public function amaci_form_updates_existing_data()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Criar um amaci para editar
        $amaci = Amaci::factory()->create([
            'user_id' => $user->id,
            'type' => 'Corpo',
            'observations' => 'Observação inicial',
            'date' => '2023-01-01',
        ]);

        // Novos dados para atualização
        $newData = [
            'type' => 'Cabeça',
            'observations' => 'Observação atualizada',
            'date' => '2023-02-15',
        ];

        // Editar o amaci através do componente Livewire
        Livewire::test(AmaciForm::class, ['user' => $user])
            ->call('editAmaci', $amaci->id)
            ->assertSet('editing', true)
            ->assertSet('editingAmaciId', $amaci->id)
            ->assertSet('type', 'Corpo')
            ->set('type', $newData['type'])
            ->set('observations', $newData['observations'])
            ->set('date', $newData['date'])
            ->call('save');

        // Verificar se os dados foram atualizados no banco
        $this->assertDatabaseHas('amacis', [
            'id' => $amaci->id,
            'user_id' => $user->id,
            'type' => $newData['type'],
            'observations' => $newData['observations'],
            'date' => $newData['date'],
        ]);
    }

    #[Test]
    public function amaci_form_validates_required_fields()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Tentar salvar sem os campos obrigatórios
        Livewire::test(AmaciForm::class, ['user' => $user])
            ->set('type', '')  // Campo obrigatório vazio
            ->set('observations', 'Alguma observação')
            ->set('date', '2023-05-15')
            ->call('save')
            ->assertHasErrors(['type' => 'required']);
    }

    #[Test]
    public function amaci_form_validates_date_field()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Tentar salvar com data inválida
        Livewire::test(AmaciForm::class, ['user' => $user])
            ->set('type', 'Cabeça')
            ->set('observations', 'Alguma observação')
            ->set('date', 'data-inválida')
            ->call('save')
            ->assertHasErrors(['date' => 'date']);
    }

    #[Test]
    public function amaci_form_deletes_existing_data()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Criar um amaci para deletar
        $amaci = Amaci::factory()->create([
            'user_id' => $user->id,
            'type' => 'Corpo',
        ]);

        // Verificar que o amaci existe
        $this->assertDatabaseHas('amacis', [
            'id' => $amaci->id,
        ]);

        // Deletar o amaci através do componente Livewire
        Livewire::test(AmaciForm::class, ['user' => $user])
            ->call('deleteAmaci', $amaci->id);

        // Verificar se o amaci foi removido do banco
        $this->assertDatabaseMissing('amacis', [
            'id' => $amaci->id,
        ]);
    }

    #[Test]
    public function amaci_form_can_cancel_edit()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Criar um amaci para editar
        $amaci = Amaci::factory()->create([
            'user_id' => $user->id,
            'type' => 'Corpo',
            'observations' => 'Observação inicial',
        ]);

        // Iniciar a edição e depois cancelar
        Livewire::test(AmaciForm::class, ['user' => $user])
            ->call('editAmaci', $amaci->id)
            ->assertSet('editing', true)
            ->assertSet('editingAmaciId', $amaci->id)
            ->call('cancelEdit')
            ->assertSet('editing', false)
            ->assertSet('editingAmaciId', null)
            ->assertSet('type', '')
            ->assertSet('observations', '');
    }

    #[Test]
    public function amaci_form_dispatches_profile_updated_event()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Dados de teste para amaci
        $amaciData = [
            'type' => 'Cabeça',
            'observations' => 'Teste de evento',
            'date' => '2023-05-15',
        ];

        // Verificar se o evento é disparado ao salvar
        Livewire::test(AmaciForm::class, ['user' => $user])
            ->set('type', $amaciData['type'])
            ->set('observations', $amaciData['observations'])
            ->set('date', $amaciData['date'])
            ->call('save')
            ->assertDispatched('profile-updated');
    }

    #[Test]
    public function amaci_form_cannot_edit_another_users_amaci()
    {
        // Criar dois usuários para o teste
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Criar um amaci para o user2
        $amaci = Amaci::factory()->create([
            'user_id' => $user2->id,
            'type' => 'Corpo',
        ]);

        // Tentar editar o amaci de user2 com o componente conectado a user1
        $component = Livewire::test(AmaciForm::class, ['user' => $user1])
            ->call('editAmaci', $amaci->id);

        // Verificar que não foi possível editar (campos continuam vazios)
        $component->assertSet('editing', false)
            ->assertSet('editingAmaciId', null)
            ->assertSet('type', '');
    }

    #[Test]
    public function amaci_form_cannot_delete_another_users_amaci()
    {
        // Criar dois usuários para o teste
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Criar um amaci para o user2
        $amaci = Amaci::factory()->create([
            'user_id' => $user2->id,
            'type' => 'Corpo',
        ]);

        // Tentar deletar o amaci de user2 com o componente conectado a user1
        Livewire::test(AmaciForm::class, ['user' => $user1])
            ->call('deleteAmaci', $amaci->id);

        // Verificar que o amaci ainda existe
        $this->assertDatabaseHas('amacis', [
            'id' => $amaci->id,
        ]);
    }
}
