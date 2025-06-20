<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Course;
use App\Models\ReligiousCourse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_course()
    {
        $course = Course::factory()->create([
            'name' => 'Curso de Desenvolvimento Mediúnico',
            'active' => true
        ]);

        $this->assertDatabaseHas('courses', [
            'name' => 'Curso de Desenvolvimento Mediúnico',
            'active' => true
        ]);

        $this->assertEquals('Curso de Desenvolvimento Mediúnico', $course->name);
        $this->assertTrue($course->active);
    }

    public function test_can_update_course()
    {
        $course = Course::factory()->create();

        $course->update([
            'name' => 'Curso Atualizado',
            'active' => false
        ]);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Curso Atualizado',
            'active' => false
        ]);
    }

    public function test_can_delete_course()
    {
        $course = Course::factory()->create();

        $courseId = $course->id;

        $course->delete();

        $this->assertDatabaseMissing('courses', [
            'id' => $courseId,
        ]);
    }

    public function test_has_many_religious_courses_relationship()
    {
        $course = Course::factory()->create();
        $user = User::factory()->create();

        $religiousCourse1 = ReligiousCourse::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id
        ]);

        $religiousCourse2 = ReligiousCourse::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id
        ]);

        $this->assertCount(2, $course->religiousCourses);
        $this->assertInstanceOf(ReligiousCourse::class, $course->religiousCourses->first());
    }
}
