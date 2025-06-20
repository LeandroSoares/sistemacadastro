<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\MagicType;
use App\Models\DivineMagic;
use Illuminate\Database\Eloquent\Factories\Factory;

class DivineMagicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DivineMagic::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'magic_type_id' => MagicType::factory(),
            'date' => $this->faker->date(),
            'performed' => $this->faker->boolean(70),
            'observations' => $this->faker->optional(0.8)->paragraph()
        ];
    }

    /**
     * Indicate that the divine magic has been performed.
     */
    public function performed(): static
    {
        return $this->state(fn (array $attributes) => [
            'performed' => true,
        ]);
    }

    /**
     * Indicate that the divine magic has not been performed.
     */
    public function notPerformed(): static
    {
        return $this->state(fn (array $attributes) => [
            'performed' => false,
        ]);
    }
}
