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
            'name' => 'Admin',
            'password' => 'Admin123',
            'phone_number' => '9284594158',
            'email' => 'admin123@fitclub.com',
        ]);

        $this->call(SubscriptionPlanSeeder::class);
        $this->call(BeginnerExercisesSeeder::class);
        $this->call(IntermediateExerciseSeeder::class);
        $this->call(ExpertExercisesSeeder::class);
        
    }
}
