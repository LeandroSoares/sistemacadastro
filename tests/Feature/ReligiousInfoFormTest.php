<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ReligiousInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\ReligiousInfoForm;
use Tests\TestCase;

class ReligiousInfoFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_religious_info_form_saves_and_displays_data()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Dados de teste para informações religiosas
        $infoData = [
            'start_date' => '2020-01-01',
            'start_location' => 'São Paulo',
            'charity_house_start' => '2020-02-01',
            'charity_house_end' => '2022-01-01',
            'charity_house_observations' => 'Participação ativa como médium',
            'development_start' => '2020-03-01',
            'development_end' => '2021-03-01',
            'service_start' => '2021-04-01',
            'umbanda_baptism' => '2020-05-01',
            'cambone_experience' => true,
            'cambone_start_date' => '2020-06-01',
            'cambone_end_date' => '2021-06-01'
        ];

        // Salvar dados através do componente Livewire
        Livewire::test(ReligiousInfoForm::class, ['user' => $user])
            ->set('start_date', $infoData['start_date'])
            ->set('start_location', $infoData['start_location'])
            ->set('charity_house_start', $infoData['charity_house_start'])
            ->set('charity_house_end', $infoData['charity_house_end'])
            ->set('charity_house_observations', $infoData['charity_house_observations'])
            ->set('development_start', $infoData['development_start'])
            ->set('development_end', $infoData['development_end'])
            ->set('service_start', $infoData['service_start'])
            ->set('umbanda_baptism', $infoData['umbanda_baptism'])
            ->set('cambone_experience', $infoData['cambone_experience'])
            ->set('cambone_start_date', $infoData['cambone_start_date'])
            ->set('cambone_end_date', $infoData['cambone_end_date'])
            ->call('save');

        // Verificar se os dados foram salvos no banco
        $this->assertDatabaseHas('religious_infos', [
            'user_id' => $user->id,
            'start_date' => $infoData['start_date'],
            'start_location' => $infoData['start_location'],
            'charity_house_start' => $infoData['charity_house_start'],
            'charity_house_end' => $infoData['charity_house_end'],
            'charity_house_observations' => $infoData['charity_house_observations'],
            'development_start' => $infoData['development_start'],
            'development_end' => $infoData['development_end'],
            'service_start' => $infoData['service_start'],
            'umbanda_baptism' => $infoData['umbanda_baptism'],
            'cambone_experience' => $infoData['cambone_experience'],
            'cambone_start_date' => $infoData['cambone_start_date'],
            'cambone_end_date' => $infoData['cambone_end_date']
        ]);

        // Verificar se os dados são exibidos corretamente quando o formulário é carregado novamente
        Livewire::test(ReligiousInfoForm::class, ['user' => $user->fresh()])
            ->assertSet('start_date', $infoData['start_date'])
            ->assertSet('start_location', $infoData['start_location'])
            ->assertSet('charity_house_start', $infoData['charity_house_start'])
            ->assertSet('charity_house_end', $infoData['charity_house_end'])
            ->assertSet('charity_house_observations', $infoData['charity_house_observations'])
            ->assertSet('development_start', $infoData['development_start'])
            ->assertSet('development_end', $infoData['development_end'])
            ->assertSet('service_start', $infoData['service_start'])
            ->assertSet('umbanda_baptism', $infoData['umbanda_baptism'])
            ->assertSet('cambone_experience', $infoData['cambone_experience'])
            ->assertSet('cambone_start_date', $infoData['cambone_start_date'])
            ->assertSet('cambone_end_date', $infoData['cambone_end_date']);
    }

    public function test_religious_info_form_updates_existing_data()
    {
        // Criar um usuário e informações religiosas existentes
        $user = User::factory()->create();
        $religiousInfo = ReligiousInfo::factory()->create([
            'user_id' => $user->id,
            'start_date' => '2018-01-01',
            'start_location' => 'Rio de Janeiro',
            'charity_house_start' => '2018-02-01',
        ]);

        // Novos dados para atualização
        $updatedData = [
            'start_date' => '2019-01-01',
            'start_location' => 'Belo Horizonte',
            'charity_house_start' => '2019-02-01',
            'charity_house_end' => '2021-02-01',
            'development_start' => '2019-03-01'
        ];

        // Atualizar dados através do componente Livewire
        Livewire::test(ReligiousInfoForm::class, ['user' => $user->fresh()])
            ->set('start_date', $updatedData['start_date'])
            ->set('start_location', $updatedData['start_location'])
            ->set('charity_house_start', $updatedData['charity_house_start'])
            ->set('charity_house_end', $updatedData['charity_house_end'])
            ->set('development_start', $updatedData['development_start'])
            ->call('save');

        // Verificar se os dados foram atualizados no banco
        $this->assertDatabaseHas('religious_infos', [
            'user_id' => $user->id,
            'start_date' => $updatedData['start_date'],
            'start_location' => $updatedData['start_location'],
            'charity_house_start' => $updatedData['charity_house_start'],
            'charity_house_end' => $updatedData['charity_house_end'],
            'development_start' => $updatedData['development_start']
        ]);
    }

    public function test_religious_info_form_validates_required_fields()
    {
        $user = User::factory()->create();

        // Tentar salvar sem preencher campos obrigatórios
        Livewire::test(ReligiousInfoForm::class, ['user' => $user])
            ->set('start_date', '')
            ->set('start_location', '')
            ->set('charity_house_start', '')
            ->call('save')
            ->assertHasErrors(['start_date', 'start_location', 'charity_house_start']);

        // Verificar que os dados não foram salvos no banco
        $this->assertDatabaseMissing('religious_infos', [
            'user_id' => $user->id
        ]);
    }

    public function test_religious_info_form_validates_date_fields()
    {
        $user = User::factory()->create();

        // Tentar salvar com formatos de data inválidos
        Livewire::test(ReligiousInfoForm::class, ['user' => $user])
            ->set('start_date', 'data-invalida')
            ->set('start_location', 'São Paulo')
            ->set('charity_house_start', '2020-01-01')
            ->call('save')
            ->assertHasErrors(['start_date']);

        // Verificar que os dados não foram salvos no banco
        $this->assertDatabaseMissing('religious_infos', [
            'user_id' => $user->id
        ]);
    }

    public function test_cambone_experience_toggle()
    {
        $user = User::factory()->create();

        // Criar componente com experiência de cambone desativada
        $component = Livewire::test(ReligiousInfoForm::class, ['user' => $user])
            ->set('start_date', '2020-01-01')
            ->set('start_location', 'São Paulo')
            ->set('charity_house_start', '2020-02-01')
            ->set('cambone_experience', false)
            ->call('save');

        // Verificar se foi salvo com cambone_experience como false
        $this->assertDatabaseHas('religious_infos', [
            'user_id' => $user->id,
            'cambone_experience' => 0
        ]);

        // Atualizar para ativar a experiência de cambone
        Livewire::test(ReligiousInfoForm::class, ['user' => $user->fresh()])
            ->set('cambone_experience', true)
            ->set('cambone_start_date', '2020-03-01')
            ->set('cambone_end_date', '2021-03-01')
            ->call('save');

        // Verificar se foi atualizado com cambone_experience como true e as datas
        $this->assertDatabaseHas('religious_infos', [
            'user_id' => $user->id,
            'cambone_experience' => 1,
            'cambone_start_date' => '2020-03-01',
            'cambone_end_date' => '2021-03-01'
        ]);
    }
}
