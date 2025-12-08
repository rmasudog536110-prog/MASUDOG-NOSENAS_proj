<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create Admin User with hashed password
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@fitclub.com',
            'phone_number' => '1234567890',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Instructor User with hashed password
        User::create([
            'name' => 'Instructor User',
            'email' => 'instructor@fitclub.com',
            'phone_number' => '1234567891',
            'password' => Hash::make('instructor123'),
            'role' => 'instructor',
            'is_active' => true,
        ]);

        // Create Customer User
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@fitclub.com',
            'phone_number' => '1234567892',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'is_active' => true,
        ]);

        $this->call(SubscriptionPlanSeeder::class);
        $this->call(BeginnerExercisesSeeder::class);
        $this->call(IntermediateExerciseSeeder::class);
        $this->call(ExpertExercisesSeeder::class);
        $this->call(TrainingProgramSeeder::class);
        $this->call(SubscriptionSeeder::class);
        
    }
}
