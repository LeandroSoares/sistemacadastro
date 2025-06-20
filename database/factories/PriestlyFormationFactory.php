<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\PriestlyFormation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriestlyFormationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PriestlyFormation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $theologyStart = $this->faker->dateTimeBetween('-10 years', '-5 years')->format('Y-m-d');
        $theologyEnd = $this->faker->dateTimeBetween($theologyStart, '-3 years')->format('Y-m-d');
        $priesthoodStart = $this->faker->dateTimeBetween($theologyEnd, '-2 years')->format('Y-m-d');

        // Tratar o optional de forma segura para evitar erros com null
        $priesthoodEndDate = $this->faker->boolean(80)
            ? $this->faker->dateTimeBetween($priesthoodStart, 'now')->format('Y-m-d')
            : null;

        return [
            'user_id' => User::factory(),
            'theology_start' => $theologyStart,
            'theology_end' => $theologyEnd,
            'priesthood_start' => $priesthoodStart,
            'priesthood_end' => $priesthoodEndDate
        ];
    }

    /**
     * Configure the model with only required fields.
     */
    public function minimal(): static
    {
        return $this->state(fn (array $attributes) => [
            'theology_start' => $this->faker->date(),
            'theology_end' => null,
            'priesthood_start' => $this->faker->date(),
            'priesthood_end' => null
        ]);
    }

    /**
     * Configure the model with ongoing priesthood (no end date).
     */
    public function ongoingPriesthood(): static
    {
        return $this->state(fn (array $attributes) => [
            'priesthood_end' => null
        ]);
    }

    /**
     * Configure the model for a complete priesthood formation.
     */
    public function complete(): static
    {
        $theologyStart = $this->faker->dateTimeBetween('-10 years', '-8 years')->format('Y-m-d');
        $theologyEnd = $this->faker->dateTimeBetween($theologyStart, '-6 years')->format('Y-m-d');
        $priesthoodStart = $this->faker->dateTimeBetween($theologyEnd, '-4 years')->format('Y-m-d');
        $priesthoodEnd = $this->faker->dateTimeBetween($priesthoodStart, '-1 year')->format('Y-m-d');

        return $this->state(fn (array $attributes) => [
            'theology_start' => $theologyStart,
            'theology_end' => $theologyEnd,
            'priesthood_start' => $priesthoodStart,
            'priesthood_end' => $priesthoodEnd
        ]);
    }
}
