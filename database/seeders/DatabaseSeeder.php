<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Child;
use App\Models\Daycare;
use App\Models\Health;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $me = User::create([
            'name' => 'Dehondt Matthieu',
            'email' => 'mthdht@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $me->profile()->create([
            'last_name' => 'Dehondt',
            'first_name' => 'Matthieu',
            'role' => 'professional',
            'phone' => '0123456789',
        ]);

        $me->daycares()->saveMany(Daycare::factory(2)
                                    ->has(Child::factory(5)
                                    ->has(User::factory(2)
                                        ->hasProfile(1,['role' => 'guardian']), 'guardians')
                                    ->has(Health::factory()
                                        ->hasAllergies(3)
                                        ->hasIllnesses(1)
                                        ->hasMedications(2))
                                    ->hasAdditionalNotes(2))->create());
    }
}
