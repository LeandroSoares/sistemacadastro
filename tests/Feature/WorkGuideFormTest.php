<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WorkGuide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\WorkGuideForm;
use Tests\TestCase;

class WorkGuideFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_work_guide_form_saves_and_displays_data()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Dados de teste para guias de trabalho
        $guideData = [
            'caboclo' => 'Caboclo Pena Verde',
            'cabocla' => 'Cabocla Jurema',
            'ogum' => 'Ogum Beira-Mar',
            'xango' => 'Xangô Pedra Preta',
            'baiano' => 'Baiano Zé do Coco',
            'baiana' => 'Baiana Maria',
            'preto_velho' => 'Pai Joaquim de Angola',
            'preta_velha' => 'Vovó Maria Conga',
            'exu' => 'Exu Tranca Ruas',
            'pombagira' => 'Maria Padilha'
        ];

        // Salvar dados através do componente Livewire
        Livewire::test(WorkGuideForm::class, ['user' => $user])
            ->set('caboclo', $guideData['caboclo'])
            ->set('cabocla', $guideData['cabocla'])
            ->set('ogum', $guideData['ogum'])
            ->set('xango', $guideData['xango'])
            ->set('baiano', $guideData['baiano'])
            ->set('baiana', $guideData['baiana'])
            ->set('preto_velho', $guideData['preto_velho'])
            ->set('preta_velha', $guideData['preta_velha'])
            ->set('exu', $guideData['exu'])
            ->set('pombagira', $guideData['pombagira'])
            ->call('save');

        // Verificar se os dados foram salvos no banco
        $this->assertDatabaseHas('work_guides', [
            'user_id' => $user->id,
            'caboclo' => $guideData['caboclo'],
            'cabocla' => $guideData['cabocla'],
            'ogum' => $guideData['ogum'],
            'xango' => $guideData['xango'],
            'baiano' => $guideData['baiano'],
            'baiana' => $guideData['baiana'],
            'preto_velho' => $guideData['preto_velho'],
            'preta_velha' => $guideData['preta_velha'],
            'exu' => $guideData['exu'],
            'pombagira' => $guideData['pombagira']
        ]);

        // Verificar se os dados são exibidos corretamente quando o formulário é carregado novamente
        Livewire::test(WorkGuideForm::class, ['user' => $user->fresh()])
            ->assertSet('caboclo', $guideData['caboclo'])
            ->assertSet('cabocla', $guideData['cabocla'])
            ->assertSet('ogum', $guideData['ogum'])
            ->assertSet('xango', $guideData['xango'])
            ->assertSet('baiano', $guideData['baiano'])
            ->assertSet('baiana', $guideData['baiana'])
            ->assertSet('preto_velho', $guideData['preto_velho'])
            ->assertSet('preta_velha', $guideData['preta_velha'])
            ->assertSet('exu', $guideData['exu'])
            ->assertSet('pombagira', $guideData['pombagira']);
    }

    public function test_work_guide_form_updates_existing_data()
    {
        // Criar um usuário e guias existentes
        $user = User::factory()->create();
        $workGuide = WorkGuide::factory()->create([
            'user_id' => $user->id,
            'caboclo' => 'Caboclo Arruda',
            'cabocla' => 'Cabocla Jussara'
        ]);

        // Novos dados para atualização
        $updatedData = [
            'caboclo' => 'Caboclo Tupinambá',
            'cabocla' => 'Cabocla Iracema',
            'exu' => 'Exu Caveira',
            'pombagira' => 'Pomba Gira Rainha'
        ];

        // Atualizar dados através do componente Livewire
        Livewire::test(WorkGuideForm::class, ['user' => $user->fresh()])
            ->set('caboclo', $updatedData['caboclo'])
            ->set('cabocla', $updatedData['cabocla'])
            ->set('exu', $updatedData['exu'])
            ->set('pombagira', $updatedData['pombagira'])
            ->call('save');

        // Verificar se os dados foram atualizados no banco
        $this->assertDatabaseHas('work_guides', [
            'user_id' => $user->id,
            'caboclo' => $updatedData['caboclo'],
            'cabocla' => $updatedData['cabocla'],
            'exu' => $updatedData['exu'],
            'pombagira' => $updatedData['pombagira']
        ]);
    }

    public function test_work_guide_form_validates_data()
    {
        $user = User::factory()->create();

        // Verificar que o componente aceita dados vazios (já que os campos são nullable)
        $component = Livewire::test(WorkGuideForm::class, ['user' => $user])
            ->set('caboclo', '')
            ->set('cabocla', '')
            ->call('save');

        // Verificar que o registro foi criado mesmo com valores vazios
        $workGuide = WorkGuide::where('user_id', $user->id)->first();
        $this->assertNotNull($workGuide);

        // Verificar que o componente aceita strings normais
        $component = Livewire::test(WorkGuideForm::class, ['user' => $user])
            ->set('caboclo', 'Caboclo Tupã')
            ->call('save');

        // Verificar que o dado foi salvo
        $this->assertDatabaseHas('work_guides', [
            'user_id' => $user->id,
            'caboclo' => 'Caboclo Tupã'
        ]);
    }
}
