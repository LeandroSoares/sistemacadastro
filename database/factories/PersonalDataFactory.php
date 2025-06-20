<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\PersonalData;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PersonalData::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'zip_code' => $this->faker->postcode(),
            'email' => $this->faker->unique()->safeEmail(),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'rg' => $this->faker->numerify('##.###.###-#'),
            'birth_date' => $this->faker->date(),
            'home_phone' => $this->faker->optional()->phoneNumber(),
            'mobile_phone' => $this->faker->phoneNumber(),
            'work_phone' => $this->faker->optional()->phoneNumber(),
            'emergency_contact' => $this->faker->optional()->name()
        ];
    }

    /**
     * Indicate that the personal data is minimal.
     */
    public function minimal(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'mobile_phone' => $this->faker->phoneNumber(),
        ]);
    }

    /**
     * Indicate that the personal data is complete.
     */
    public function complete(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'zip_code' => $this->faker->postcode(),
            'email' => $this->faker->unique()->safeEmail(),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'rg' => $this->faker->numerify('##.###.###-#'),
            'birth_date' => $this->faker->date(),
            'home_phone' => $this->faker->phoneNumber(),
            'mobile_phone' => $this->faker->phoneNumber(),
            'work_phone' => $this->faker->phoneNumber(),
            'emergency_contact' => $this->faker->name()
        ]);
    }
}
