<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\EntityConsecration;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntityConsecrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EntityConsecration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $entities = [
            'Caboclo', 'Cabocla', 'Preto Velho', 'Preta Velha',
            'Baiano', 'Baiana', 'Exu', 'Pombagira', 'Boiadeiro'
        ];

        return [
            'user_id' => User::factory(),
            'entity' => $this->faker->randomElement($entities),
            'date' => $this->faker->date(),
            'name' => $this->faker->name()
        ];
    }

    /**
     * Configure the model for a caboclo entity.
     */
    public function caboclo(): static
    {
        return $this->state(fn (array $attributes) => [
            'entity' => 'Caboclo',
            'name' => 'Caboclo ' . $this->faker->word()
        ]);
    }

    /**
     * Configure the model for an exu entity.
     */
    public function exu(): static
    {
        return $this->state(fn (array $attributes) => [
            'entity' => 'Exu',
            'name' => 'Exu ' . $this->faker->word()
        ]);
    }
}
