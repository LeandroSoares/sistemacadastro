<?php

namespace Database\Factories;

use App\Models\Mystery;
use Illuminate\Database\Eloquent\Factories\Factory;

class MysteryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mystery::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'active' => true
        ];
    }

    /**
     * Indicate that the mystery is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }
}
