<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Amaci;
use Illuminate\Database\Eloquent\Factories\Factory;

class AmaciFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Amaci::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Cabeça', 'Corpo', 'Completo', 'Outro'];

        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement($types),
            'date' => $this->faker->date(),
            'observations' => $this->faker->optional()->paragraph()
        ];
    }

    /**
     * Indicate that the amaci is for the head.
     */
    public function forHead(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'Cabeça',
        ]);
    }

    /**
     * Indicate that the amaci is for the body.
     */
    public function forBody(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'Corpo',
        ]);
    }

    /**
     * Indicate that the amaci is complete.
     */
    public function complete(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'Completo',
        ]);
    }
}
