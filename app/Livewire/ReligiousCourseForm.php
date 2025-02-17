<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Course;
use App\Models\ReligiousCourse;
use Livewire\Component;

class ReligiousCourseForm extends Component
{
    public User $user;
    public $course_id = '';
    public $date = '';
    public $finished = false;
    
    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function save()
    {
        $validatedData = $this->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'nullable|date',
            'finished' => 'boolean'
        ], [
            'course_id.required' => 'O curso é obrigatório',
            'course_id.exists' => 'Curso inválido',
            'date.date' => 'Data inválida'
        ]);

        $this->user->religiousCourses()->create($validatedData);
        
        session()->flash('message', 'Curso religioso adicionado com sucesso.');
        $this->reset(['course_id', 'date', 'finished']);
    }

    public function deleteCourse($id)
    {
        $course = ReligiousCourse::find($id);
        if ($course && $course->user_id === $this->user->id) {
            $course->delete();
            session()->flash('message', 'Curso removido com sucesso.');
        }
    }

    public function render()
    {
        return view('livewire.religious-course-form', [
            'courses' => $this->user->religiousCourses()
                ->with('course')
                ->orderBy('date', 'desc')
                ->get(),
            'availableCourses' => Course::where('active', true)
                ->orderBy('name')
                ->get()
        ]);
    }
}
