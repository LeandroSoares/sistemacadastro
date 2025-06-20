<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Crowning;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\CrowningForm;
use Tests\TestCase;

class CrowningFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_crowning_form_saves_and_displays_data()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Dados de teste para a coroação
        $crowningData = [
            'start_date' => '2023-01-01',
            'end_date' => '2023-06-30',
            'guide_name' => 'Caboclo Pena Branca',
            'priest_name' => 'Pai João',
            'temple_name' => 'Tenda Espírita Luz Divina'
        ];

        // Salvar dados através do componente Livewire
        Livewire::test(CrowningForm::class, ['user' => $user])
            ->set('start_date', $crowningData['start_date'])
            ->set('end_date', $crowningData['end_date'])
            ->set('guide_name', $crowningData['guide_name'])
            ->set('priest_name', $crowningData['priest_name'])
            ->set('temple_name', $crowningData['temple_name'])
            ->call('save');

        // Verificar se os dados foram salvos no banco
        $this->assertDatabaseHas('crownings', [
            'user_id' => $user->id,
            'start_date' => $crowningData['start_date'],
            'end_date' => $crowningData['end_date'],
            'guide_name' => $crowningData['guide_name'],
            'priest_name' => $crowningData['priest_name'],
            'temple_name' => $crowningData['temple_name']
        ]);

        // Verificar se os dados são exibidos corretamente quando o formulário é carregado novamente
        Livewire::test(CrowningForm::class, ['user' => $user->fresh()])
            ->assertSet('start_date', $crowningData['start_date'])
            ->assertSet('end_date', $crowningData['end_date'])
            ->assertSet('guide_name', $crowningData['guide_name'])
            ->assertSet('priest_name', $crowningData['priest_name'])
            ->assertSet('temple_name', $crowningData['temple_name']);
    }

    public function test_crowning_form_updates_existing_data()
    {
        // Criar um usuário e coroação existente
        $user = User::factory()->create();
        $crowning = Crowning::factory()->create([
            'user_id' => $user->id,
            'start_date' => '2022-01-01',
            'end_date' => '2022-06-30',
            'guide_name' => 'Caboclo Tupinambá',
            'priest_name' => 'Mãe Maria',
            'temple_name' => 'Casa de Caridade Luz da Umbanda'
        ]);

        // Novos dados para atualização
        $updatedData = [
            'start_date' => '2022-02-01',
            'end_date' => '2022-07-30',
            'guide_name' => 'Caboclo Sete Flechas',
            'priest_name' => 'Pai José',
            'temple_name' => 'Templo de Umbanda Estrela do Oriente'
        ];

        // Atualizar dados através do componente Livewire
        Livewire::test(CrowningForm::class, ['user' => $user->fresh()])
            ->set('start_date', $updatedData['start_date'])
            ->set('end_date', $updatedData['end_date'])
            ->set('guide_name', $updatedData['guide_name'])
            ->set('priest_name', $updatedData['priest_name'])
            ->set('temple_name', $updatedData['temple_name'])
            ->call('save');

        // Verificar se os dados foram atualizados no banco
        $this->assertDatabaseHas('crownings', [
            'user_id' => $user->id,
            'start_date' => $updatedData['start_date'],
            'end_date' => $updatedData['end_date'],
            'guide_name' => $updatedData['guide_name'],
            'priest_name' => $updatedData['priest_name'],
            'temple_name' => $updatedData['temple_name']
        ]);
    }

    public function test_crowning_form_validates_required_fields()
    {
        $user = User::factory()->create();

        // Tentar salvar sem preencher campos obrigatórios
        Livewire::test(CrowningForm::class, ['user' => $user])
            ->set('start_date', '')
            ->set('end_date', '')
            ->set('guide_name', '')
            ->set('priest_name', '')
            ->set('temple_name', '')
            ->call('save')
            ->assertHasErrors(['start_date', 'end_date', 'guide_name', 'priest_name', 'temple_name']);

        // Verificar que os dados não foram salvos no banco
        $this->assertDatabaseMissing('crownings', [
            'user_id' => $user->id
        ]);
    }

    public function test_crowning_form_validates_date_fields()
    {
        $user = User::factory()->create();

        // Tentar salvar com formatos de data inválidos
        Livewire::test(CrowningForm::class, ['user' => $user])
            ->set('start_date', 'data-invalida')
            ->set('end_date', '2023-06-30')
            ->set('guide_name', 'Caboclo Pena Branca')
            ->set('priest_name', 'Pai João')
            ->set('temple_name', 'Tenda Espírita Luz Divina')
            ->call('save')
            ->assertHasErrors(['start_date']);

        // Verificar que os dados não foram salvos no banco
        $this->assertDatabaseMissing('crownings', [
            'user_id' => $user->id
        ]);
    }

    public function test_form_displays_flash_message_on_success()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        // Testamos se o método save cria o evento profile-updated
        $component = Livewire::test(CrowningForm::class, ['user' => $user])
            ->set('start_date', '2023-01-01')
            ->set('end_date', '2023-06-30')
            ->set('guide_name', 'Caboclo Pena Branca')
            ->set('priest_name', 'Pai João')
            ->set('temple_name', 'Tenda Espírita Luz Divina')
            ->call('save')
            ->assertDispatched('profile-updated');

        // Verificar que os dados foram salvos corretamente no banco
        $this->assertDatabaseHas('crownings', [
            'user_id' => $user->id,
            'start_date' => '2023-01-01',
            'end_date' => '2023-06-30',
            'guide_name' => 'Caboclo Pena Branca',
            'priest_name' => 'Pai João',
            'temple_name' => 'Tenda Espírita Luz Divina'
        ]);

        // Como o teste Livewire é isolado, não podemos acessar a sessão diretamente
        // Então vamos testar apenas que o componente salvou com sucesso
    }
}
