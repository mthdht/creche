<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Health;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Allergy>
 */
class AllergyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'health_id' => Health::factory(),
            'name' => $this->faker->randomElement(['Pollen', 'Arachides', 'Lait', 'Œufs', 'Fruits de mer']),
            'severity' => $this->faker->randomElement(['low', 'medium', 'high']),
            'description' => $this->faker->sentence(),
        ];
    }
}
