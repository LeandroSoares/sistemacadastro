<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Mystery;
use App\Models\InitiatedMystery;
use Illuminate\Database\Eloquent\Factories\Factory;

class InitiatedMysteryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InitiatedMystery::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'mystery_id' => Mystery::factory(),
            'date' => $this->faker->date(),
            'completed' => $this->faker->boolean(),
            'observations' => $this->faker->optional()->paragraph()
        ];
    }

    /**
     * Indicate that the mystery initiation is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed' => true,
        ]);
    }
}
