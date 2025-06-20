<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\LastTemple;
use Illuminate\Database\Eloquent\Factories\Factory;

class LastTempleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LastTemple::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $functions = ['Médium', 'Cambono', 'Ogã', 'Assistente', 'Zelador', 'Zeladora'];
        $exitReasons = [
            'Mudança de cidade',
            'Divergências doutrinárias',
            'Progresso espiritual',
            'Questões pessoais',
            'Fechamento do templo'
        ];

        return [
            'user_id' => User::factory(),
            'name' => 'Templo ' . $this->faker->company(),
            'address' => $this->faker->address(),
            'leader_name' => $this->faker->name(),
            'function' => $this->faker->randomElement($functions),
            'exit_reason' => $this->faker->randomElement($exitReasons)
        ];
    }

    /**
     * Configure the model with minimal information.
     */
    public function minimal(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Templo ' . $this->faker->company(),
            'leader_name' => $this->faker->name(),
            'function' => 'Médium',
            'address' => null,
            'exit_reason' => null
        ]);
    }
}
