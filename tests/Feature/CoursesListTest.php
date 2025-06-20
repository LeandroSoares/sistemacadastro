<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\ReligiousCourse;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\CoursesList;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoursesListTest extends TestCase
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

    public function test_component_can_render()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Criar alguns cursos para serem listados
        Course::create(['name' => 'Curso 1', 'active' => true]);
        Course::create(['name' => 'Curso 2', 'active' => false]);

        // Verificar se o componente renderiza corretamente
        Livewire::test(CoursesList::class)
            ->assertViewIs('livewire.courses-list')
            ->assertViewHas('courses');
    }    public function test_courses_are_displayed_properly()
    {
        // Limpar todos os cursos existentes
        Course::query()->delete();

        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Criar cursos para serem listados
        Course::create(['name' => 'Curso de Umbanda', 'active' => true]);
        Course::create(['name' => 'Desenvolvimento Mediúnico', 'active' => false]);

        // Verificar se os cursos são exibidos corretamente
        $component = Livewire::test(CoursesList::class);
        $data = $component->viewData('courses');

        // Verificar que existem os cursos que criamos
        $this->assertEquals(2, $data->count());

        // Verificar que os nomes dos cursos estão no HTML da resposta
        $html = $component->html();
        $this->assertStringContainsString('Curso de Umbanda', $html);
        $this->assertStringContainsString('Desenvolvimento Mediúnico', $html);
    }

    public function test_search_functionality()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Criar cursos para serem pesquisados
        Course::create(['name' => 'Curso de Umbanda', 'active' => true]);
        Course::create(['name' => 'Desenvolvimento Mediúnico', 'active' => true]);
        Course::create(['name' => 'Curso de Caboclos', 'active' => true]);

        // Testar funcionalidade de pesquisa
        $component = Livewire::test(CoursesList::class)
            ->set('search', 'Desenvolvimento')
            ->assertViewHas('courses');

        $results = $component->viewData('courses');
        $this->assertEquals(1, $results->count());
        $this->assertEquals('Desenvolvimento Mediúnico', $results->first()->name);
    }

    public function test_admin_can_delete_course()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Criar um curso para ser excluído
        $course = Course::create(['name' => 'Curso para Excluir', 'active' => true]);

        // Excluir o curso
        Livewire::test(CoursesList::class)
            ->call('deleteCourse', $course->id);

        // Verificar se o curso foi excluído
        $this->assertDatabaseMissing('courses', [
            'id' => $course->id
        ]);
    }

    public function test_manager_can_delete_course()
    {
        // Criar um usuário gerente
        $manager = User::factory()->create();
        $manager->assignRole('manager');

        $this->actingAs($manager);

        // Criar um curso para ser excluído
        $course = Course::create(['name' => 'Curso para Excluir', 'active' => true]);

        // Excluir o curso
        Livewire::test(CoursesList::class)
            ->call('deleteCourse', $course->id);

        // Verificar se o curso foi excluído
        $this->assertDatabaseMissing('courses', [
            'id' => $course->id
        ]);
    }

    public function test_regular_user_cannot_delete_course()
    {
        // Criar um usuário comum
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user);

        // Criar um curso para tentar excluir
        $course = Course::create(['name' => 'Curso Protegido', 'active' => true]);

        // Tentar excluir o curso
        Livewire::test(CoursesList::class)
            ->call('deleteCourse', $course->id);

        // Verificar que o curso ainda existe
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Curso Protegido'
        ]);
    }

    public function test_cannot_delete_course_with_enrolled_students()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Criar um curso com alunos matriculados
        $course = Course::create(['name' => 'Curso com Matriculados', 'active' => true]);
        $student = User::factory()->create();

        // Criar uma matrícula para o curso
        ReligiousCourse::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
            'location' => 'Centro de Umbanda',
            'certificate' => true
        ]);

        // Tentar excluir o curso
        Livewire::test(CoursesList::class)
            ->call('deleteCourse', $course->id);

        // Verificar que o curso não foi excluído
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Curso com Matriculados'
        ]);
    }

    public function test_admin_can_toggle_course_status()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Criar um curso ativo
        $course = Course::create(['name' => 'Curso Ativo', 'active' => true]);

        // Testar a troca de status
        Livewire::test(CoursesList::class)
            ->call('toggleActive', $course->id);

        // Verificar se o status foi alterado
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'active' => false
        ]);

        // Testar a troca de status novamente
        Livewire::test(CoursesList::class)
            ->call('toggleActive', $course->id);

        // Verificar se o status foi alterado de volta
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'active' => true
        ]);
    }

    public function test_regular_user_cannot_toggle_course_status()
    {
        // Criar um usuário comum
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user);

        // Criar um curso ativo
        $course = Course::create(['name' => 'Curso Ativo', 'active' => true]);

        // Tentar trocar o status
        Livewire::test(CoursesList::class)
            ->call('toggleActive', $course->id);

        // Verificar que o status não mudou
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'active' => true
        ]);
    }    public function test_pagination()
    {
        // Limpar todos os cursos existentes
        Course::query()->delete();

        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Criar exatamente 15 cursos para testar paginação
        for ($i = 1; $i <= 15; $i++) {
            Course::create(['name' => "Curso Teste Paginação {$i}", 'active' => true]);
        }

        // Verificar a contagem total
        $this->assertEquals(15, Course::count());

        // Testar a paginação
        $component = Livewire::test(CoursesList::class)
            ->set('perPage', 10)
            ->assertViewHas('courses');

        $courses = $component->viewData('courses');
        $this->assertEquals(10, $courses->count()); // Primeira página tem 10 itens

        // 15 itens com 10 por página = 2 páginas
        $this->assertEquals(2, $courses->lastPage());
    }
}
