<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->optional()->phoneNumber,
            'address' => $this->faker->optional()->address,
            'role' => $this->faker->randomElement(['professional', 'guardian']),
            'relationship' => fn ($attrs) => $attrs['role'] === 'guardian' ? $this->faker->randomElement(['mère', 'père', 'tuteur']) : null,
            'birth_date' => $this->faker->optional()->date,
            'sexe' => $this->faker->randomElement(['male', 'female']),
            'avatar' => $this->faker->optional()->imageUrl(200, 200, 'people'),
        ];
    }
}
