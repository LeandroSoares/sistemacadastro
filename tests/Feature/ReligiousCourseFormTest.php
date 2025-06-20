<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\ReligiousCourse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\ReligiousCourseForm;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ReligiousCourseFormTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function religious_course_form_saves_and_displays_data()
    {
        // Criar um curso disponível
        $course = Course::factory()->create([
            'name' => 'Curso de Umbanda Básico',
            'active' => true
        ]);

        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Dados de teste para o curso religioso
        $courseData = [
            'course_id' => $course->id,
            'date' => '2023-05-15',
            'finished' => true,
            'has_initiation' => false,
            'observations' => 'Observações de teste',
        ];

        // Salvar dados através do componente Livewire
        Livewire::test(ReligiousCourseForm::class, ['user' => $user])
            ->set('course_id', $courseData['course_id'])
            ->set('date', $courseData['date'])
            ->set('finished', $courseData['finished'])
            ->set('has_initiation', $courseData['has_initiation'])
            ->set('observations', $courseData['observations'])
            ->call('save');

        // Verificar se os dados foram salvos no banco
        $this->assertDatabaseHas('religious_courses', [
            'user_id' => $user->id,
            'course_id' => $courseData['course_id'],
            'date' => $courseData['date'],
            'finished' => $courseData['finished'],
            'has_initiation' => $courseData['has_initiation'],
            'observations' => $courseData['observations'],
        ]);

        // Verificar se a ação foi realizada com sucesso
        Livewire::test(ReligiousCourseForm::class, ['user' => $user])
            ->set('course_id', $courseData['course_id'])
            ->set('date', $courseData['date'])
            ->call('save')
            ->assertDispatched('profile-updated');
    }

    #[Test]
    public function religious_course_form_updates_existing_data()
    {
        // Criar um curso disponível
        $course = Course::factory()->create([
            'name' => 'Curso de Umbanda Básico',
            'active' => true
        ]);

        // Criar um curso alternativo para atualização
        $alternativeCourse = Course::factory()->create([
            'name' => 'Curso de Mediunidade Avançado',
            'active' => true
        ]);

        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Criar um curso religioso para editar
        $religiousCourse = ReligiousCourse::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'date' => '2023-01-01',
            'finished' => false,
            'has_initiation' => false,
            'observations' => 'Observação inicial',
        ]);

        // Novos dados para atualização
        $newData = [
            'course_id' => $alternativeCourse->id,
            'date' => '2023-02-15',
            'finished' => true,
            'has_initiation' => true,
            'initiation_date' => '2023-03-01',
            'observations' => 'Observação atualizada',
        ];

        // Editar o curso religioso através do componente Livewire
        Livewire::test(ReligiousCourseForm::class, ['user' => $user])
            ->call('editCourse', $religiousCourse->id)
            ->assertSet('editing', true)
            ->assertSet('editingCourseId', $religiousCourse->id)
            ->assertSet('course_id', $course->id)
            ->set('course_id', $newData['course_id'])
            ->set('date', $newData['date'])
            ->set('finished', $newData['finished'])
            ->set('has_initiation', $newData['has_initiation'])
            ->set('initiation_date', $newData['initiation_date'])
            ->set('observations', $newData['observations'])
            ->call('save');

        // Verificar se os dados foram atualizados no banco
        $this->assertDatabaseHas('religious_courses', [
            'id' => $religiousCourse->id,
            'user_id' => $user->id,
            'course_id' => $newData['course_id'],
            'date' => $newData['date'],
            'finished' => $newData['finished'],
            'has_initiation' => $newData['has_initiation'],
            'initiation_date' => $newData['initiation_date'],
            'observations' => $newData['observations'],
        ]);
    }

    #[Test]
    public function religious_course_form_validates_required_fields()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Tentar salvar sem os campos obrigatórios
        Livewire::test(ReligiousCourseForm::class, ['user' => $user])
            ->set('course_id', '') // Campo obrigatório vazio
            ->set('date', '')      // Campo obrigatório vazio
            ->call('save')
            ->assertHasErrors(['course_id' => 'required', 'date' => 'required']);
    }

    #[Test]
    public function religious_course_form_validates_date_fields()
    {
        // Criar um curso
        $course = Course::factory()->create(['active' => true]);

        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Tentar salvar com data inválida
        Livewire::test(ReligiousCourseForm::class, ['user' => $user])
            ->set('course_id', $course->id)
            ->set('date', 'data-inválida')
            ->set('initiation_date', 'data-inválida')
            ->call('save')
            ->assertHasErrors(['date' => 'date', 'initiation_date' => 'date']);
    }

    #[Test]
    public function religious_course_form_validates_course_exists()
    {
        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Tentar salvar com um ID de curso que não existe
        Livewire::test(ReligiousCourseForm::class, ['user' => $user])
            ->set('course_id', 9999) // ID que não existe
            ->set('date', '2023-05-15')
            ->call('save')
            ->assertHasErrors(['course_id' => 'exists']);
    }

    #[Test]
    public function religious_course_form_deletes_existing_data()
    {
        // Criar um curso
        $course = Course::factory()->create();

        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Criar um curso religioso para deletar
        $religiousCourse = ReligiousCourse::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        // Verificar que o curso religioso existe
        $this->assertDatabaseHas('religious_courses', [
            'id' => $religiousCourse->id,
        ]);

        // Deletar o curso religioso através do componente Livewire
        Livewire::test(ReligiousCourseForm::class, ['user' => $user])
            ->call('deleteCourse', $religiousCourse->id);

        // Verificar se o curso religioso foi removido do banco
        $this->assertDatabaseMissing('religious_courses', [
            'id' => $religiousCourse->id,
        ]);
    }

    #[Test]
    public function religious_course_form_can_cancel_edit()
    {
        // Criar um curso
        $course = Course::factory()->create();

        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Criar um curso religioso para editar
        $religiousCourse = ReligiousCourse::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'date' => '2023-01-01',
            'observations' => 'Observação inicial',
        ]);

        // Iniciar a edição e depois cancelar
        Livewire::test(ReligiousCourseForm::class, ['user' => $user])
            ->call('editCourse', $religiousCourse->id)
            ->assertSet('editing', true)
            ->assertSet('editingCourseId', $religiousCourse->id)
            ->assertSet('course_id', $course->id)
            ->call('cancelEdit')
            ->assertSet('editing', false)
            ->assertSet('editingCourseId', null)
            ->assertSet('course_id', '')
            ->assertSet('observations', '');
    }

    #[Test]
    public function religious_course_form_dispatches_profile_updated_event()
    {
        // Criar um curso
        $course = Course::factory()->create(['active' => true]);

        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Salvar curso e verificar se o evento é disparado
        Livewire::test(ReligiousCourseForm::class, ['user' => $user])
            ->set('course_id', $course->id)
            ->set('date', '2023-05-15')
            ->call('save')
            ->assertDispatched('profile-updated');
    }

    #[Test]
    public function religious_course_form_handles_null_dates()
    {
        // Criar um curso
        $course = Course::factory()->create(['active' => true]);

        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Salvar com datas vazias (que serão convertidas para null)
        Livewire::test(ReligiousCourseForm::class, ['user' => $user])
            ->set('course_id', $course->id)
            ->set('date', '')  // Vazio, mas é obrigatório
            ->set('has_initiation', true)
            ->set('initiation_date', '') // Vazio
            ->call('save')
            ->assertHasErrors(['date']); // Deve dar erro em date porque é obrigatório
    }

    #[Test]
    public function religious_course_form_lists_available_courses()
    {
        // Criar alguns cursos
        $course1 = Course::factory()->create([
            'name' => 'Curso A',
            'active' => true
        ]);

        $course2 = Course::factory()->create([
            'name' => 'Curso B',
            'active' => true
        ]);

        $inactiveCourse = Course::factory()->create([
            'name' => 'Curso Inativo',
            'active' => false
        ]);

        // Criar um usuário para o teste
        $user = User::factory()->create();

        // Criar um curso religioso já associado ao usuário
        ReligiousCourse::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course1->id,
        ]);

        // Testar o componente
        $component = Livewire::test(ReligiousCourseForm::class, ['user' => $user]);

        // Obter a variável availableCourses do componente
        $availableCourses = $component->viewData('availableCourses');

        // Verificar se o curso2 está disponível (ativo e não inscrito)
        $this->assertTrue($availableCourses->contains('id', $course2->id));

        // Verificar se o course1 não está disponível (já inscrito)
        $this->assertFalse($availableCourses->contains('id', $course1->id));

        // Verificar se o inactiveCourse não está disponível (inativo)
        $this->assertFalse($availableCourses->contains('id', $inactiveCourse->id));
    }

    #[Test]
    public function religious_course_form_cannot_edit_another_users_course()
    {
        // Criar um curso
        $course = Course::factory()->create();

        // Criar dois usuários para o teste
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Criar um curso religioso para o user2
        $religiousCourse = ReligiousCourse::factory()->create([
            'user_id' => $user2->id,
            'course_id' => $course->id,
        ]);

        // Tentar editar o curso de user2 com o componente conectado a user1
        $component = Livewire::test(ReligiousCourseForm::class, ['user' => $user1])
            ->call('editCourse', $religiousCourse->id);

        // Verificar que não foi possível editar (campos continuam vazios)
        $component->assertSet('editing', false)
            ->assertSet('editingCourseId', null)
            ->assertSet('course_id', '');
    }

    #[Test]
    public function religious_course_form_cannot_delete_another_users_course()
    {
        // Criar um curso
        $course = Course::factory()->create();

        // Criar dois usuários para o teste
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Criar um curso religioso para o user2
        $religiousCourse = ReligiousCourse::factory()->create([
            'user_id' => $user2->id,
            'course_id' => $course->id,
        ]);

        // Tentar deletar o curso de user2 com o componente conectado a user1
        Livewire::test(ReligiousCourseForm::class, ['user' => $user1])
            ->call('deleteCourse', $religiousCourse->id);

        // Verificar que o curso religioso ainda existe
        $this->assertDatabaseHas('religious_courses', [
            'id' => $religiousCourse->id,
        ]);
    }
}
