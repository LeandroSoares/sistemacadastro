<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Orisha;
use App\Models\InitiatedOrisha;
use Illuminate\Database\Eloquent\Factories\Factory;

class InitiatedOrishaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InitiatedOrisha::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'orisha_id' => Orisha::factory(),
            'initiated' => $this->faker->boolean(),
            'observations' => $this->faker->optional()->paragraph()
        ];
    }

    /**
     * Indicate that the orisha has been initiated.
     */
    public function initiated(): static
    {
        return $this->state(fn (array $attributes) => [
            'initiated' => true,
        ]);
    }

    /**
     * Indicate that the orisha has not been initiated.
     */
    public function notInitiated(): static
    {
        return $this->state(fn (array $attributes) => [
            'initiated' => false,
        ]);
    }
}
