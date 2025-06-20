<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Crossing;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrossingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Crossing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'entity' => $this->faker->randomElement(['Exu', 'Pombagira', 'Boiadeiro', 'Marinheiro', 'Caboclo', 'Preto Velho']),
            'date' => $this->faker->date(),
            'purpose' => $this->faker->sentence()
        ];
    }

    /**
     * Configure the model for a specific entity type.
     */
    public function forEntity(string $entity): static
    {
        return $this->state(fn (array $attributes) => [
            'entity' => $entity,
        ]);
    }
}
