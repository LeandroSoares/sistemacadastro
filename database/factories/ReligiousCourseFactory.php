<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Course;
use App\Models\ReligiousCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReligiousCourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReligiousCourse::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'date' => $this->faker->date(),
            'finished' => $this->faker->boolean(),
            'has_initiation' => $this->faker->boolean(),
            'initiation_date' => $this->faker->optional()->date(),
            'observations' => $this->faker->optional()->paragraph()
        ];
    }

    /**
     * Indicate that the course is finished.
     */
    public function finished(): static
    {
        return $this->state(fn (array $attributes) => [
            'finished' => true,
        ]);
    }

    /**
     * Indicate that the course has initiation.
     */
    public function withInitiation(): static
    {
        return $this->state(fn (array $attributes) => [
            'has_initiation' => true,
            'initiation_date' => $this->faker->date()
        ]);
    }
}
