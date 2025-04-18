<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Child;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transmission>
 */
class TransmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $array = [
            'child_id' => 1,
            'type' => $this->faker->randomElement([
                'sieste', 'repas', 'hygiene'
            ]),
            'description' => $this->faker->sentence(),
            'duration' => $this->faker->time('H:i'),
            'datetime' => $this->faker->datetimeBetween('-2 week', 'now'),
            'severity' =>$this->faker->optional()->randomElement(['low', 'high','medium'])
        ];
        
        if ($array['type'] == 'sieste') {
            $array['duration'] = $this->faker->time('H:i');
        }

        return $array;
    }
}
