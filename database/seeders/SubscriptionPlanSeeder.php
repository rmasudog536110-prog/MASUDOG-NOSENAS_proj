<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscription_plans')->insertOrIgnore([
    [
        'name' => 'Basic Plan',
        'description' => 'Perfect for beginners who want access to basic exercise lessons and limited support.',
        'price' => 199.99,
        'duration' => 30,
        'features' => json_encode([
            'Access to beginner workouts',
            'Track progress in dashboard',
            'Community support',
        ]),
        'is_active' => true,
        'free_trial' => true,
        'duration_days' => 7,
    ],
    [
        'name' => 'Pro Plan',
        'description' => 'For users who want more guidance and personalized workout recommendations.',
        'price' => 349.99,
        'duration' => 90,
        'features' => json_encode([
            'All Basic Plan features',
            'Personalized exercise plans',
            'Nutrition tips and guides',
            'Priority email support',
        ]),
        'is_active' => true,
        'free_trial' => false,
        'duration_days' => null,
    ],
    [
        'name' => 'Premium Plan',
        'description' => 'Best for advanced users who want full access to all workout programs and premium support.',
        'price' => 669.99,
        'duration' => 180,
        'features' => json_encode([
            'All Pro Plan features',
            '1-on-1 virtual coaching sessions',
            'Access to advanced workout videos',
            'Downloadable fitness resources',
            'Exclusive member events',
        ]),
        'is_active' => true,
        'free_trial' => false,
        'duration_days' => null,
    ],
]);

    }
}
