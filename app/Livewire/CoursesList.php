<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class CoursesList extends Component
{
    use WithPagination;

    public $search = '';
    public $canManage;
    public $perPage = 10;
    public $perPageOptions = [10, 25, 50, 100];

    public function mount()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $this->canManage = $user->hasAnyRole(['admin', 'manager']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function deleteCourse($courseId)
    {
        /** @var \App\Models\User */
        $currentUser = Auth::user();
        
        if (!$currentUser->hasAnyRole(['admin', 'manager'])) {
            session()->flash('error', 'Você não tem permissão para excluir cursos.');
            return;
        }

        $course = Course::find($courseId);
        if (!$course) {
            session()->flash('error', 'Curso não encontrado.');
            return;
        }

        // Verifica se há alunos matriculados
        if ($course->religiousCourses()->count() > 0) {
            session()->flash('error', 'Não é possível excluir um curso que possui alunos matriculados.');
            return;
        }

        $course->delete();
        session()->flash('success', 'Curso excluído com sucesso!');
    }

    public function toggleActive($courseId)
    {
        /** @var \App\Models\User */
        $currentUser = Auth::user();
        
        if (!$currentUser->hasAnyRole(['admin', 'manager'])) {
            session()->flash('error', 'Você não tem permissão para alterar o status do curso.');
            return;
        }

        $course = Course::find($courseId);
        if (!$course) {
            session()->flash('error', 'Curso não encontrado.');
            return;
        }

        $course->active = !$course->active;
        $course->save();

        session()->flash('success', 'Status do curso atualizado com sucesso!');
    }

    public function render()
    {
        return view('livewire.courses-list', [
            'courses' => Course::when($this->search, function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->paginate($this->perPage)
        ]);
    }
} 