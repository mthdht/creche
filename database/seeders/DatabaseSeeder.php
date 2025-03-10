<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Child;
use App\Models\Daycare;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(3)
            ->hasProfile(1, ['role' => 'professional'])
            ->has(Daycare::factory(3)->has(Child::factory(15)->has(User::factory(2)->hasProfile(1,['role' => 'guardian']), 'guardians')))
            ->create();
    }
}
