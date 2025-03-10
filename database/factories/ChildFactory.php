<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Daycare;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child>
 */
class ChildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date(),
            'sexe' => $this->faker->randomElement(['male', 'female']),
            'avatar' => $this->faker->imageUrl(200, 200, 'cats', true), // Image placeholder
            'daycare_id' => Daycare::factory(), 
        ];
    }
}
