<?php

namespace Tests\Feature;

use App\Livewire\ProfileProgressBar;
use App\Models\User;
use App\Models\PersonalData;
use App\Models\ReligiousInfo;
use App\Models\PriestlyFormation;
use App\Models\HeadOrisha;
use App\Models\WorkGuide;
use App\Models\ForceCross;
use App\Models\InitiatedOrisha;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProfileProgressBarTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    #[Test]
    public function component_can_render()
    {
        $user = User::factory()->create();

        Livewire::test(ProfileProgressBar::class, ['user' => $user])
            ->assertViewIs('livewire.profile-progress-bar');
    }

    #[Test]
    public function component_displays_zero_progress_for_new_user()
    {
        $user = User::factory()->create();

        $component = Livewire::test(ProfileProgressBar::class, ['user' => $user]);

        // Usuário recém-criado deve ter 0% de progresso
        $component->assertSet('progress', 0);
    }

    #[Test]
    public function component_updates_progress_when_profile_updated()
    {
        $user = User::factory()->create();

        // Cria o componente com 0% inicial
        $component = Livewire::test(ProfileProgressBar::class, ['user' => $user]);
        $component->assertSet('progress', 0);

        // Adiciona dados pessoais para o usuário
        PersonalData::factory()->create([
            'user_id' => $user->id,
            'name' => 'Nome Teste',
            'email' => 'email@teste.com',
        ]);

        // Dispara o evento para atualizar o progresso
        $component->dispatch('profile-updated');

        // Verifica se o progresso foi atualizado após o evento
        $component->assertSet('progress', function ($progress) {
            return $progress > 0;
        });
    }

    #[Test]
    public function component_shows_detailed_progress()
    {
        $user = User::factory()->create();

        // Cria registros necessários para testar o progresso detalhado
        PersonalData::factory()->create(['user_id' => $user->id]);
        ReligiousInfo::factory()->create(['user_id' => $user->id]);

        $component = Livewire::test(ProfileProgressBar::class, ['user' => $user]);

        // Verifica se o progresso detalhado contém as seções esperadas
        $component->assertSet('detailedProgress', function ($detailedProgress) {
            return
                count($detailedProgress) > 0 &&
                collect($detailedProgress)->where('section', 'personalData')->count() === 1 &&
                collect($detailedProgress)->where('section', 'religiousInfo')->count() === 1;
        });
    }

    #[Test]
    public function component_respects_fixed_option()
    {
        $user = User::factory()->create();

        // Com a opção isFixed = true
        $fixedComponent = Livewire::test(ProfileProgressBar::class, [
            'user' => $user,
            'isFixed' => true
        ]);

        // Com a opção isFixed = false (padrão)
        $nonFixedComponent = Livewire::test(ProfileProgressBar::class, [
            'user' => $user,
            'isFixed' => false
        ]);

        // Verifica se a propriedade isFixed foi corretamente definida
        $fixedComponent->assertSet('isFixed', true);
        $nonFixedComponent->assertSet('isFixed', false);
    }
}
