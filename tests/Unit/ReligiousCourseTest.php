<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\ReligiousCourse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReligiousCourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_religious_course()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $religiousCourse = ReligiousCourse::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'date' => '2025-06-15',
            'finished' => true,
            'has_initiation' => true,
            'initiation_date' => '2025-06-20',
            'observations' => 'Curso finalizado com sucesso'
        ]);

        $this->assertDatabaseHas('religious_courses', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'date' => '2025-06-15',
            'finished' => true,
            'has_initiation' => true,
            'initiation_date' => '2025-06-20',
            'observations' => 'Curso finalizado com sucesso'
        ]);

        $this->assertEquals($user->id, $religiousCourse->user_id);
        $this->assertEquals($course->id, $religiousCourse->course_id);
        $this->assertEquals('2025-06-15', $religiousCourse->date);
        $this->assertTrue($religiousCourse->finished);
        $this->assertTrue($religiousCourse->has_initiation);
        $this->assertEquals('2025-06-20', $religiousCourse->initiation_date);
        $this->assertEquals('Curso finalizado com sucesso', $religiousCourse->observations);
    }

    public function test_can_update_religious_course()
    {
        $religiousCourse = ReligiousCourse::factory()->create();

        $religiousCourse->update([
            'date' => '2025-06-19',
            'finished' => false,
            'observations' => 'Curso em andamento'
        ]);

        $this->assertDatabaseHas('religious_courses', [
            'id' => $religiousCourse->id,
            'date' => '2025-06-19',
            'finished' => false,
            'observations' => 'Curso em andamento'
        ]);
    }

    public function test_belongs_to_user_relationship()
    {
        $user = User::factory()->create();
        $religiousCourse = ReligiousCourse::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(User::class, $religiousCourse->user);
        $this->assertEquals($user->id, $religiousCourse->user->id);
    }

    public function test_belongs_to_course_relationship()
    {
        $course = Course::factory()->create();
        $religiousCourse = ReligiousCourse::factory()->create([
            'course_id' => $course->id
        ]);

        $this->assertInstanceOf(Course::class, $religiousCourse->course);
        $this->assertEquals($course->id, $religiousCourse->course->id);
    }

    public function test_factory_finished_state()
    {
        $religiousCourse = ReligiousCourse::factory()->finished()->create();
        $this->assertTrue($religiousCourse->finished);
    }

    public function test_factory_with_initiation_state()
    {
        $religiousCourse = ReligiousCourse::factory()->withInitiation()->create();
        $this->assertTrue($religiousCourse->has_initiation);
        $this->assertNotNull($religiousCourse->initiation_date);
    }
}
