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
    public $has_initiation = false;
    public $initiation_date = '';
    public $observations = '';
    public $editing = false;
    public $editingCourseId = null;

    protected $rules = [
        'course_id' => 'required|exists:courses,id',
        'date' => 'required|date',
        'finished' => 'boolean',
        'has_initiation' => 'boolean',
        'initiation_date' => 'nullable|date',
        'observations' => 'nullable|string|max:255'
    ];

    protected $messages = [
        'course_id.required' => 'O curso é obrigatório',
        'course_id.exists' => 'Curso inválido',
        'date.date' => 'Data inválida',
        'initiation_date.date' => 'Data de iniciação inválida'
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function editCourse($id)
    {
        $course = ReligiousCourse::find($id);
        if ($course && $course->user_id === $this->user->id) {
            $this->editing = true;
            $this->editingCourseId = $course->id;
            $this->course_id = $course->course_id;
            $this->date = $course->date;
            $this->finished = $course->finished;
            $this->has_initiation = $course->has_initiation;
            $this->initiation_date = $course->initiation_date;
            $this->observations = $course->observations;
        }
    }

    public function cancelEdit()
    {
        $this->reset([
            'editing',
            'editingCourseId',
            'course_id',
            'date',
            'finished',
            'has_initiation',
            'initiation_date',
            'observations'
        ]);
    }

    public function save()
    {
        $validatedData = $this->validate();
        $validatedData['date'] = empty($validatedData['date']) ? null : $validatedData['date'];
        $validatedData['initiation_date'] = empty($validatedData['initiation_date']) ? null : $validatedData['initiation_date'];
        if ($this->editing && $this->editingCourseId) {
            $course = ReligiousCourse::find($this->editingCourseId);
            if ($course && $course->user_id === $this->user->id) {
                $course->update($validatedData);
                session()->flash('message', 'Curso atualizado com sucesso.');
            }
        } else {
            $this->user->religiousCourses()->create($validatedData);
            session()->flash('message', 'Curso religioso adicionado com sucesso.');
        }

        $this->reset([
            'editing',
            'editingCourseId',
            'course_id',
            'date',
            'finished',
            'has_initiation',
            'initiation_date',
            'observations'
        ]);
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
                ->whereDoesntHave('religiousCourses', function ($query) {
                    $query->where('user_id', $this->user->id);
                })
                ->orderBy('name')
                ->get()
        ]);
    }
}
