<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PersonalData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\PersonalDataForm;
use Tests\TestCase;

class PersonalDataFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_rg_field_accepts_multiple_formats()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Valores de RG nos três formatos
        $rgTradicional = '12.345.678-9';
        $rgFormatoCPF = '123.456.789-00';
        $rgSemFormatacao = '123456789';

        // 1. Testa formato tradicional do RG
        Livewire::test(PersonalDataForm::class, ['user' => $user])
            ->set('name', 'Nome Teste')
            ->set('address', 'Endereço Teste')
            ->set('zip_code', '12345-678')
            ->set('email', 'email@teste.com')
            ->set('rg', $rgTradicional)
            ->set('birth_date', '2000-01-01')
            ->set('mobile_phone', '(11) 99999-9999')
            ->set('emergency_contact', 'Contato Emergência')
            ->call('save');

        $this->assertEquals($rgTradicional, $user->fresh()->personalData->rg);

        // Limpar dados
        $user->personalData()->delete();

        // 2. Testa formato de CPF no RG
        Livewire::test(PersonalDataForm::class, ['user' => $user])
            ->set('name', 'Nome Teste')
            ->set('address', 'Endereço Teste')
            ->set('zip_code', '12345-678')
            ->set('email', 'email@teste.com')
            ->set('rg', $rgFormatoCPF)
            ->set('birth_date', '2000-01-01')
            ->set('mobile_phone', '(11) 99999-9999')
            ->set('emergency_contact', 'Contato Emergência')
            ->call('save');

        $this->assertEquals($rgFormatoCPF, $user->fresh()->personalData->rg);

        // Limpar dados
        $user->personalData()->delete();

        // 3. Testa RG sem formatação (apenas números)
        Livewire::test(PersonalDataForm::class, ['user' => $user])
            ->set('name', 'Nome Teste')
            ->set('address', 'Endereço Teste')
            ->set('zip_code', '12345-678')
            ->set('email', 'email@teste.com')
            ->set('rg', $rgSemFormatacao)
            ->set('birth_date', '2000-01-01')
            ->set('mobile_phone', '(11) 99999-9999')
            ->set('emergency_contact', 'Contato Emergência')
            ->call('save');

        $this->assertEquals($rgSemFormatacao, $user->fresh()->personalData->rg);
    }
}
