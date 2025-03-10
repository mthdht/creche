<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Child;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdditionalNotes>
 */
class AdditionalNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'child_id' => Child::factory(),
            'note' => $this->faker->sentence(), // Génère une note aléatoire
            'severity' => $this->faker->randomElement(['low', 'medium', 'high']), // Sévérité aléatoire
        ];
    }
}
