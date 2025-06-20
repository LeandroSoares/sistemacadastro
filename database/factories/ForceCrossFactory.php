<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ForceCross;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForceCrossFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ForceCross::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'top' => $this->faker->word,
            'bottom' => $this->faker->word,
            'left' => $this->faker->word,
            'right' => $this->faker->word
        ];
    }

    /**
     * Indicate that the force cross is complete.
     */
    public function complete(): static
    {
        return $this->state(fn (array $attributes) => [
            'top' => $this->faker->word,
            'bottom' => $this->faker->word,
            'left' => $this->faker->word,
            'right' => $this->faker->word
        ]);
    }

    /**
     * Indicate that the force cross is minimal.
     */
    public function minimal(): static
    {
        return $this->state(fn (array $attributes) => [
            'top' => 'Desconhecido',
            'bottom' => 'Desconhecido',
            'left' => 'Desconhecido',
            'right' => 'Desconhecido'
        ]);
    }
}
