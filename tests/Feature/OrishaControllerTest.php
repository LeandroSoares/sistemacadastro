<?php

namespace Tests\Feature;

use App\Http\Controllers\OrishaController;
use App\Models\Orisha;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;

class OrishaControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;    protected function setUp(): void
    {
        parent::setUp();

        // Criando papéis necessários
        $adminRole = Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);

        // Criar permissões para Orishas
        $viewOrishas = \Spatie\Permission\Models\Permission::create(['name' => 'view orishas']);
        $createOrishas = \Spatie\Permission\Models\Permission::create(['name' => 'create orishas']);
        $editOrishas = \Spatie\Permission\Models\Permission::create(['name' => 'edit orishas']);
        $deleteOrishas = \Spatie\Permission\Models\Permission::create(['name' => 'delete orishas']);

        // Associar permissões ao papel de admin
        $adminRole->givePermissionTo($viewOrishas);
        $adminRole->givePermissionTo($createOrishas);
        $adminRole->givePermissionTo($editOrishas);
        $adminRole->givePermissionTo($deleteOrishas);

        // Criar um usuário admin para os testes
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    #[Test]
    public function index_displays_orishas()
    {
        // Criar alguns orixás de teste
        $orisha1 = Orisha::factory()->create(['name' => 'Oxalá']);
        $orisha2 = Orisha::factory()->create(['name' => 'Iemanjá']);

        // Acessa a página index como admin
        $this->actingAs($this->admin);
        $response = $this->get(route('orishas.index'));

        // Verifica se a página foi carregada corretamente
        $response->assertStatus(200);
        $response->assertViewIs('orishas.index');
        $response->assertViewHas('orishas');

        // Verifica se os orixás estão presentes na resposta
        $response->assertSee($orisha1->name);
        $response->assertSee($orisha2->name);
    }

    #[Test]
    public function create_displays_form()
    {
        $this->actingAs($this->admin);
        $response = $this->get(route('orishas.create'));

        $response->assertStatus(200);
        $response->assertViewIs('orishas.create');
    }

    #[Test]
    public function store_creates_new_orisha()
    {
        $this->actingAs($this->admin);

        $orishaData = [
            'name' => 'Oxóssi',
            'description' => 'Orixá caçador e senhor das matas',
            'is_right' => true,
            'is_left' => false,
            'active' => true
        ];

        $response = $this->post(route('orishas.store'), $orishaData);

        // Verifica se foi redirecionado para a página certa
        $response->assertRedirect(route('orishas.index'));
        $response->assertSessionHas('success', 'Orixá criado com sucesso.');

        // Verifica se o orixá foi criado no banco
        $this->assertDatabaseHas('orishas', [
            'name' => 'Oxóssi',
            'description' => 'Orixá caçador e senhor das matas',
            'is_right' => true,
            'is_left' => false,
            'active' => true
        ]);
    }

    #[Test]
    public function store_validates_required_fields()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('orishas.store'), [
            // 'name' => sem nome
            'description' => 'Descrição teste'
        ]);

        $response->assertSessionHasErrors('name');

        $response = $this->post(route('orishas.store'), [
            'name' => 'Nome teste'
            // 'description' => sem descrição
        ]);

        $response->assertSessionHasErrors('description');
    }

    #[Test]
    public function edit_displays_form_with_orisha()
    {
        $this->actingAs($this->admin);

        $orisha = Orisha::factory()->create([
            'name' => 'Ogum',
            'description' => 'Orixá guerreiro'
        ]);

        $response = $this->get(route('orishas.edit', $orisha));

        $response->assertStatus(200);
        $response->assertViewIs('orishas.edit');
        $response->assertViewHas('orisha', $orisha);
        $response->assertSee('Ogum');
        $response->assertSee('Orixá guerreiro');
    }

    #[Test]
    public function update_changes_orisha()
    {
        $this->actingAs($this->admin);

        $orisha = Orisha::factory()->create([
            'name' => 'Xangô Antigo',
            'description' => 'Descrição antiga'
        ]);

        $updatedData = [
            'name' => 'Xangô Atualizado',
            'description' => 'Descrição atualizada',
            'is_right' => true,
            'is_left' => false,
            'active' => true
        ];

        $response = $this->put(route('orishas.update', $orisha), $updatedData);

        $response->assertRedirect(route('orishas.index'));
        $response->assertSessionHas('success', 'Orixá atualizado com sucesso.');

        $this->assertDatabaseHas('orishas', [
            'id' => $orisha->id,
            'name' => 'Xangô Atualizado',
            'description' => 'Descrição atualizada'
        ]);
    }

    #[Test]
    public function update_validates_required_fields()
    {
        $this->actingAs($this->admin);

        $orisha = Orisha::factory()->create();

        $response = $this->put(route('orishas.update', $orisha), [
            // 'name' => sem nome
            'description' => 'Descrição teste'
        ]);

        $response->assertSessionHasErrors('name');
    }

    #[Test]
    public function destroy_deletes_orisha()
    {
        $this->actingAs($this->admin);

        $orisha = Orisha::factory()->create();

        $response = $this->delete(route('orishas.destroy', $orisha));

        $response->assertRedirect(route('orishas.index'));
        $response->assertSessionHas('success', 'Orixá excluído com sucesso.');

        $this->assertDatabaseMissing('orishas', ['id' => $orisha->id]);
    }
}
