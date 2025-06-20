<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ReligiousInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReligiousInfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReligiousInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'start_date' => $this->faker->date(),
            'start_location' => $this->faker->city(),
            'charity_house_start' => $this->faker->optional()->date(),
            'charity_house_end' => $this->faker->optional()->date(),
            'charity_house_observations' => $this->faker->optional()->paragraph(),
            'development_start' => $this->faker->date(),
            'development_end' => $this->faker->optional()->date(),
            'service_start' => $this->faker->optional()->date(),
            'umbanda_baptism' => $this->faker->optional()->date(),
            'cambone_experience' => $this->faker->boolean(),
            'cambone_start_date' => $this->faker->optional()->date(),
            'cambone_end_date' => $this->faker->optional()->date()
        ];
    }

    /**
     * Indicate that the user has cambone experience.
     */
    public function withCamboneExperience(): static
    {
        return $this->state(fn (array $attributes) => [
            'cambone_experience' => true,
            'cambone_start_date' => $this->faker->date(),
            'cambone_end_date' => $this->faker->optional()->date()
        ]);
    }

    /**
     * Indicate that the user has no cambone experience.
     */
    public function withoutCamboneExperience(): static
    {
        return $this->state(fn (array $attributes) => [
            'cambone_experience' => false,
            'cambone_start_date' => null,
            'cambone_end_date' => null
        ]);
    }

    /**
     * Indicate that the religious info is minimal.
     */
    public function minimal(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => $this->faker->date(),
            'start_location' => $this->faker->city(),
            'development_start' => $this->faker->date()
        ]);
    }
}
