<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\CourseForm;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar os papéis necessários para os testes
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'user']);
    }

    public function test_admin_can_create_course()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Dados para o novo curso
        $courseData = [
            'name' => 'Curso de Desenvolvimento Mediúnico',
            'active' => true
        ];

        // Testar componente
        Livewire::test(CourseForm::class)
            ->set('name', $courseData['name'])
            ->set('active', $courseData['active'])
            ->call('save');

        // Verificar se o curso foi criado
        $this->assertDatabaseHas('courses', [
            'name' => $courseData['name'],
            'active' => $courseData['active']
        ]);
    }

    public function test_manager_can_create_course()
    {
        // Criar um usuário gerente
        $manager = User::factory()->create();
        $manager->assignRole('manager');

        $this->actingAs($manager);

        // Dados para o novo curso
        $courseData = [
            'name' => 'Curso de Umbanda',
            'active' => true
        ];

        // Testar componente
        Livewire::test(CourseForm::class)
            ->set('name', $courseData['name'])
            ->set('active', $courseData['active'])
            ->call('save');

        // Verificar se o curso foi criado
        $this->assertDatabaseHas('courses', [
            'name' => $courseData['name'],
            'active' => $courseData['active']
        ]);
    }

    public function test_admin_can_update_existing_course()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Criar um curso existente
        $existingCourse = Course::create([
            'name' => 'Curso Antigo',
            'active' => true
        ]);

        $this->actingAs($admin);

        // Dados para atualização
        $updatedData = [
            'name' => 'Curso Atualizado',
            'active' => false
        ];

        // Testar componente
        Livewire::test(CourseForm::class, ['course' => $existingCourse])
            ->set('name', $updatedData['name'])
            ->set('active', $updatedData['active'])
            ->call('save');

        // Verificar se o curso foi atualizado
        $this->assertDatabaseHas('courses', [
            'id' => $existingCourse->id,
            'name' => $updatedData['name'],
            'active' => $updatedData['active']
        ]);
    }

    public function test_regular_user_cannot_access_course_form()
    {
        // Criar um usuário regular
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user);

        // Tentar acessar o componente, que deve abortar com 403
        $response = Livewire::test(CourseForm::class);
        $response->assertStatus(403);
    }    public function test_regular_user_cannot_save_course()
    {
        // Como sabemos que o componente aborta para usuários sem permissão,
        // vamos testar de outra forma: verificar que o método save trata corretamente
        // usuários sem permissão quando de alguma forma conseguem acesso

        // Criar um usuário regular
        $user = User::factory()->create();
        $user->assignRole('user');

        // Setup do teste sem acionar o método mount (que abortaria)
        $component = new CourseForm();
        $component->course = null;
        $component->name = 'Tentativa de Curso';
        $component->active = true;

        // Configurar a sessão e autenticação para o teste
        $this->actingAs($user);

        // Chamar o método save diretamente
        $component->save();

        // Verificar que o curso não foi criado
        $this->assertDatabaseMissing('courses', [
            'name' => 'Tentativa de Curso'
        ]);
    }    public function test_form_validates_required_fields()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Verificar a contagem inicial de cursos
        $initialCount = Course::count();

        // Tentar salvar sem nome
        Livewire::test(CourseForm::class)
            ->set('name', '')
            ->set('active', true)
            ->call('save')
            ->assertHasErrors(['name']);

        // Verificar que nenhum curso novo foi criado
        $this->assertEquals($initialCount, Course::count());
    }

    public function test_form_validates_string_length()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Verificar a contagem inicial de cursos
        $initialCount = Course::count();

        // String muito longa (mais de 255 caracteres)
        $tooLongName = str_repeat('A', 256);

        // Tentar salvar com nome muito longo
        Livewire::test(CourseForm::class)
            ->set('name', $tooLongName)
            ->set('active', true)
            ->call('save')
            ->assertHasErrors(['name']);

        // Verificar que nenhum curso novo foi criado
        $this->assertEquals($initialCount, Course::count());
    }
}
