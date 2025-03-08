<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use Database\Seeders\DatabaseSeeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseManagementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_authenticated_user_can_view_courses()
    {
        $user = User::factory()->create()->assignRole('user');
        
        $response = $this->actingAs($user)->get('/courses');
        
        $response->assertStatus(200);
        $response->assertViewIs('courses.index');
    }

    public function test_guest_cannot_view_courses()
    {
        $response = $this->get('/courses');
        
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_course_creation()
    {
        $admin = User::factory()->create()->assignRole('admin');
        
        $response = $this->actingAs($admin)->get('/courses/create');
        
        $response->assertStatus(200);
        $response->assertViewIs('courses.create');
    }

    public function test_non_admin_cannot_access_course_creation()
    {
        $user = User::factory()->create()->assignRole('user');
        
        $response = $this->actingAs($user)->get('/courses/create');
        
        $response->assertStatus(403);
    }

    public function test_admin_can_access_course_edit()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $course = Course::factory()->create();
        
        $response = $this->actingAs($admin)->get("/courses/{$course->id}/edit");
        
        $response->assertStatus(200);
        $response->assertViewIs('courses.edit');
    }
}
