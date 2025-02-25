<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CourseForm extends Component
{
    public ?Course $course = null;
    public $name = '';
    public $active = true;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'active' => ['boolean'],
        ];
    }

    protected $messages = [
        'name.required' => 'O nome do curso é obrigatório',
        'name.max' => 'O nome do curso não pode ter mais de 255 caracteres',
    ];

    public function mount(?Course $course = null)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'manager'])) {
            abort(403, 'Você não tem permissão para gerenciar cursos.');
        }

        if ($course && $course->exists) {
            $this->course = $course;
            $this->name = $course->name;
            $this->active = $course->active;
        }
    }

    public function save()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'manager'])) {
            session()->flash('error', 'Você não tem permissão para gerenciar cursos.');
            return;
        }

        $this->validate();

        if ($this->course) {
            $this->course->update([
                'name' => $this->name,
                'active' => $this->active,
            ]);
            session()->flash('success', 'Curso atualizado com sucesso!');
        } else {
            Course::create([
                'name' => $this->name,
                'active' => $this->active,
            ]);
            session()->flash('success', 'Curso criado com sucesso!');
        }

        return redirect()->route('courses.index');
    }

    public function render()
    {
        return view('livewire.course-form');
    }
} 