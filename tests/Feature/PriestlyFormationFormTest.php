<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PriestlyFormation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\PriestlyFormationForm;
use Tests\TestCase;

class PriestlyFormationFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_priestly_formation_form_saves_and_displays_data()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Dados de teste para formação sacerdotal
        $formationData = [
            'theology_start' => '2020-01-01',
            'theology_end' => '2022-01-01',
            'priesthood_start' => '2022-02-01',
            'priesthood_end' => '2023-01-01',
        ];

        // Salvar dados através do componente Livewire
        Livewire::test(PriestlyFormationForm::class, ['user' => $user])
            ->set('theology_start', $formationData['theology_start'])
            ->set('theology_end', $formationData['theology_end'])
            ->set('priesthood_start', $formationData['priesthood_start'])
            ->set('priesthood_end', $formationData['priesthood_end'])
            ->call('save');

        // Verificar se os dados foram salvos no banco
        $this->assertDatabaseHas('priestly_formations', [
            'user_id' => $user->id,
            'theology_start' => $formationData['theology_start'],
            'theology_end' => $formationData['theology_end'],
            'priesthood_start' => $formationData['priesthood_start'],
            'priesthood_end' => $formationData['priesthood_end'],
        ]);

        // Verificar se os dados são exibidos corretamente quando o formulário é carregado novamente
        Livewire::test(PriestlyFormationForm::class, ['user' => $user->fresh()])
            ->assertSet('theology_start', $formationData['theology_start'])
            ->assertSet('theology_end', $formationData['theology_end'])
            ->assertSet('priesthood_start', $formationData['priesthood_start'])
            ->assertSet('priesthood_end', $formationData['priesthood_end']);
    }

    public function test_priestly_formation_form_updates_existing_data()
    {
        // Criar um usuário e formação sacerdotal existente
        $user = User::factory()->create();
        $priestlyFormation = PriestlyFormation::create([
            'user_id' => $user->id,
            'theology_start' => '2018-01-01',
            'theology_end' => '2020-01-01',
            'priesthood_start' => '2020-02-01',
            'priesthood_end' => '2021-01-01',
        ]);

        // Novos dados para atualização
        $updatedData = [
            'theology_start' => '2019-06-01',
            'theology_end' => '2021-06-01',
            'priesthood_start' => '2021-07-01',
            'priesthood_end' => '2022-07-01',
        ];

        // Atualizar dados através do componente Livewire
        Livewire::test(PriestlyFormationForm::class, ['user' => $user->fresh()])
            ->set('theology_start', $updatedData['theology_start'])
            ->set('theology_end', $updatedData['theology_end'])
            ->set('priesthood_start', $updatedData['priesthood_start'])
            ->set('priesthood_end', $updatedData['priesthood_end'])
            ->call('save');

        // Verificar se os dados foram atualizados no banco
        $this->assertDatabaseHas('priestly_formations', [
            'user_id' => $user->id,
            'theology_start' => $updatedData['theology_start'],
            'theology_end' => $updatedData['theology_end'],
            'priesthood_start' => $updatedData['priesthood_start'],
            'priesthood_end' => $updatedData['priesthood_end'],
        ]);
    }

    public function test_priestly_formation_form_validates_data()
    {
        $user = User::factory()->create();

        // Tentar salvar com dados inválidos (faltando campos obrigatórios)
        $component = Livewire::test(PriestlyFormationForm::class, ['user' => $user])
            ->set('theology_start', '')
            ->set('priesthood_start', '');

        // Verificar se a validação está sendo aplicada
        $component->call('save')
            ->assertHasErrors(['theology_start', 'priesthood_start']);

        // Verificar dados inválidos (formato de data incorreto)
        $component = Livewire::test(PriestlyFormationForm::class, ['user' => $user])
            ->set('theology_start', 'data-invalida')
            ->set('priesthood_start', '2022-01-01');

        $component->call('save')
            ->assertHasErrors(['theology_start']);

        // Verificar que os dados não foram salvos no banco
        $this->assertDatabaseMissing('priestly_formations', [
            'user_id' => $user->id,
        ]);
    }
}
