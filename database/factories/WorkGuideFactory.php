<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WorkGuide;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkGuideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkGuide::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'caboclo' => $this->faker->optional(0.8)->name,
            'cabocla' => $this->faker->optional(0.8)->name,
            'ogum' => $this->faker->optional(0.8)->name,
            'xango' => $this->faker->optional(0.8)->name,
            'baiano' => $this->faker->optional(0.8)->name,
            'baiana' => $this->faker->optional(0.8)->name,
            'preto_velho' => $this->faker->optional(0.8)->name,
            'preta_velha' => $this->faker->optional(0.8)->name,
            'boiadeiro' => $this->faker->optional(0.8)->name,
            'boiadeira' => $this->faker->optional(0.8)->name,
            'cigano' => $this->faker->optional(0.8)->name,
            'cigana' => $this->faker->optional(0.8)->name,
            'marinheiro' => $this->faker->optional(0.8)->name,
            'ere' => $this->faker->optional(0.8)->name,
            'exu' => $this->faker->optional(0.8)->name,
            'pombagira' => $this->faker->optional(0.8)->name,
            'exu_mirim' => $this->faker->optional(0.8)->name,
        ];
    }

    /**
     * Indicate that the work guide is complete.
     */
    public function complete(): static
    {
        return $this->state(fn (array $attributes) => [
            'caboclo' => $this->faker->name('male'),
            'cabocla' => $this->faker->name('female'),
            'ogum' => $this->faker->name('male'),
            'xango' => $this->faker->name('male'),
            'baiano' => $this->faker->name('male'),
            'baiana' => $this->faker->name('female'),
            'preto_velho' => $this->faker->name('male'),
            'preta_velha' => $this->faker->name('female'),
            'exu' => $this->faker->name,
            'pombagira' => $this->faker->name,
        ]);
    }
}
