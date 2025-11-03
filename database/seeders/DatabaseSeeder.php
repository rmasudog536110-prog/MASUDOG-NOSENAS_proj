<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@fitclub.com',
            'phone_number' => '1234567890',
            'password' => 'admin123',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->call(SubscriptionPlanSeeder::class);
        $this->call(BeginnerExercisesSeeder::class);
        $this->call(IntermediateExerciseSeeder::class);
        $this->call(ExpertExercisesSeeder::class);
        
    }
}
