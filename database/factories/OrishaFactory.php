<?php

namespace Database\Factories;

use App\Models\Orisha;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrishaFactory extends Factory
{
    protected $model = Orisha::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'is_right' => $this->faker->boolean,
            'is_left' => $this->faker->boolean,
            'active' => $this->faker->boolean,
        ];
    }
}
