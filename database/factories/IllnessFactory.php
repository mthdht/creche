<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Health;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Illness>
 */
class IllnessFactory extends Factory
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
            'name' => $this->faker->randomElement(['Asthme', 'Diabète', 'Epilepsie', 'Rhumatisme']),
            'description' => $this->faker->sentence(),
        ];
    }
}
