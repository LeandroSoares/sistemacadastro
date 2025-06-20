<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Crowning;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrowningFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Crowning::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-5 years', '-1 month')->format('Y-m-d');
        $endDate = $this->faker->dateTimeBetween($startDate, 'now')->format('Y-m-d');

        return [
            'user_id' => User::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'guide_name' => $this->faker->name(),
            'priest_name' => $this->faker->name(),
            'temple_name' => 'Templo ' . $this->faker->company()
        ];
    }

    /**
     * Configure the model for a complete crowning process.
     */
    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = $this->faker->dateTimeBetween('-3 years', '-6 months')->format('Y-m-d');

            return [
                'start_date' => $startDate,
                'end_date' => $this->faker->dateTimeBetween($startDate, 'now')->format('Y-m-d')
            ];
        });
    }

    /**
     * Configure the model for a recent crowning process.
     */
    public function recent(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = $this->faker->dateTimeBetween('-3 months', '-1 month')->format('Y-m-d');
            return [
                'start_date' => $startDate,
                'end_date' => $this->faker->dateTimeBetween($startDate, 'now')->format('Y-m-d')
            ];
        });
    }
}
