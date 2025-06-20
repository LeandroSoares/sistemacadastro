<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\HeadOrisha;
use Illuminate\Database\Eloquent\Factories\Factory;

class HeadOrishaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HeadOrisha::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ancestor' => $this->faker->word(),
            'front' => $this->faker->word(),
            'front_together' => $this->faker->boolean(),
            'adjunct' => $this->faker->word(),
            'adjunct_together' => $this->faker->boolean(),
            'left_side' => $this->faker->word(),
            'left_side_together' => $this->faker->boolean(),
            'right_side' => $this->faker->word(),
            'right_side_together' => $this->faker->boolean()
        ];
    }
}
