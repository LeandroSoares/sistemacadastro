<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Orisha;
use App\Models\HeadOrisha;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\HeadOrishaForm;
use Tests\TestCase;

class HeadOrishaFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_head_orisha_form_saves_and_displays_data()
    {
        // Criar orixás para teste
        $orishaNames = ['Oxalá', 'Xangô', 'Oxum', 'Iemanjá', 'Ogum'];
        foreach ($orishaNames as $name) {
            Orisha::create(['name' => $name, 'active' => true]);
        }

        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Dados de teste para Orixás
        $orishaData = [
            'ancestor' => 'Oxalá',
            'front' => 'Xangô',
            'front_together' => 'Oxum',
            'adjunct' => 'Iemanjá',
            'adjunct_together' => 'Ogum',
            'left_side' => 'Oxum',
            'left_side_together' => 'Xangô',
            'right_side' => 'Ogum',
            'right_side_together' => 'Iemanjá'
        ];

        // Salvar dados através do componente Livewire
        Livewire::test(HeadOrishaForm::class, ['user' => $user])
            ->set('ancestor', $orishaData['ancestor'])
            ->set('front', $orishaData['front'])
            ->set('front_together', $orishaData['front_together'])
            ->set('adjunct', $orishaData['adjunct'])
            ->set('adjunct_together', $orishaData['adjunct_together'])
            ->set('left_side', $orishaData['left_side'])
            ->set('left_side_together', $orishaData['left_side_together'])
            ->set('right_side', $orishaData['right_side'])
            ->set('right_side_together', $orishaData['right_side_together'])
            ->call('save');

        // Verificar se os dados foram salvos no banco
        $this->assertDatabaseHas('head_orishas', [
            'user_id' => $user->id,
            'ancestor' => $orishaData['ancestor'],
            'front' => $orishaData['front'],
            'front_together' => $orishaData['front_together'],
            'adjunct' => $orishaData['adjunct']
        ]);

        // Verificar se os dados são exibidos corretamente quando o formulário é carregado novamente
        Livewire::test(HeadOrishaForm::class, ['user' => $user->fresh()])
            ->assertSet('ancestor', $orishaData['ancestor'])
            ->assertSet('front', $orishaData['front'])
            ->assertSet('front_together', $orishaData['front_together'])
            ->assertSet('adjunct', $orishaData['adjunct'])
            ->assertSet('adjunct_together', $orishaData['adjunct_together'])
            ->assertSet('left_side', $orishaData['left_side'])
            ->assertSet('left_side_together', $orishaData['left_side_together'])
            ->assertSet('right_side', $orishaData['right_side'])
            ->assertSet('right_side_together', $orishaData['right_side_together']);
    }
}
