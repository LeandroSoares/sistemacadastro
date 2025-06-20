<?php

namespace Database\Factories;

use App\Models\Orisha;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrishaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Orisha::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'is_right' => $this->faker->boolean(70),
            'is_left' => $this->faker->boolean(30),
            'active' => true,
        ];
    }

    /**
     * Indicate that the orisha is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }

    /**
     * Indicate that the orisha is of the right side.
     */
    public function rightSide(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_right' => true,
            'is_left' => false,
        ]);
    }

    /**
     * Indicate that the orisha is of the left side.
     */
    public function leftSide(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_right' => false,
            'is_left' => true,
        ]);
    }
}
