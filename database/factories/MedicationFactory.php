<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medication>
 */
class MedicationFactory extends Factory
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
            'name' => $this->faker->word(), // Génère un nom de médicament aléatoire
            'dosage' => $this->faker->randomElement(['2 inhalations', '1 comprimé par jour', '50 mg', '5 ml deux fois par jour']),
            'note' => $this->faker->sentence(), // Ajoute une note aléatoire
        ];
    }
}
