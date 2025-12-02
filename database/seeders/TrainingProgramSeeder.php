<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingProgramSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('training_programs')->insert([
            // 1. BEGINNER PROGRAM
            [
                'title' => 'Foundation Fitness (3 Days/Week)',
                'description' => json_encode([
                    'focus' => 'Establishing movement patterns and basic endurance.',
                    'Day 1 (Full Body)' => ['Bodyweight Squats (3x15)', 'Kneeling Push-ups (3x10)', 'Glute Bridge (3x15)', 'Plank (3x45s)'],
                    'Day 2 (Cardio/Core)' => ['Jumping Jacks (10 min)', 'High Knees (5 min)', 'Crunches (3x20)', 'Bird Dog (3x10/side)'],
                    'Day 3 (Full Body)' => ['Reverse Lunges (3x10/leg)', 'Triceps Dip (3x8)', 'Mountain Climbers (3x60s)'],
                ]),
                'level' => 'beginner',
                'duration_weeks' => 4,
                'workout_counts' => 3, // Workouts per week
                'equipment_required' => 'None',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 2. INTERMEDIATE PROGRAM
            [
                'title' => 'Strength & Hypertrophy Split (4 Days/Week)',
                'description' => json_encode([
                    'focus' => 'Building functional strength using progressive overload with dumbbells.',
                    'Day 1 (Upper Push)' => ['Dumbbell Bench Press', 'Overhead Press (Dumbbell)', 'Push-Ups (Max Reps)'],
                    'Day 2 (Lower Body)' => ['Goblet Squat', 'Dumbbell Romanian Deadlift (RDL)', 'Lunges', 'Step-Ups'],
                    'Day 3 (Upper Pull/Core)' => ['Dumbbell Rows (Single-Arm)', 'Face Pulls (Band)', 'Russian Twist', 'Hanging Knee Raise'],
                    'Day 4 (Conditioning)' => ['Burpees (HIIT intervals)', 'Box Jumps', 'Plank Hip Dips'],
                ]),
                'level' => 'intermediate',
                'duration_weeks' => 6,
                'workout_counts' => 4,
                'equipment_required' => 'Dumbbells, Bench, Box/Bench, Resistance Band',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 3. EXPERT PROGRAM
            [
                'title' => 'Calisthenics & Power (5 Days/Week)',
                'description' => json_encode([
                    'focus' => 'Mastering complex bodyweight skills and explosive power.',
                    'Day 1 (Max Effort)' => ['Clean and Jerk (Heavy)', 'Front Squat (Heavy)', 'Turkish Get-Up'],
                    'Day 2 (Skill Day)' => ['Weighted Pull-Ups (Low Reps)', 'Muscle-Up (Bar) - attempts', 'L-Sit (Hold)'],
                    'Day 3 (Active Rest)' => ['Light cardio and mobility work'],
                    'Day 4 (Power Push)' => ['Handstand Push-Ups', 'Weighted Dips', 'Plyometric Push-Ups (Clapping)'],
                    'Day 5 (Unilateral & Core)' => ['Pistol Squat (3x5/leg)', 'Single-Arm Dumbbell Thruster', 'Dragon Flag (Negatives)'],
                ]),
                'level' => 'expert',
                'duration_weeks' => 8,
                'workout_counts' => 5,
                'equipment_required' => 'Barbell, Dumbbells, Pull-up Bar, Dip Bars, Parallettes',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 4. HARDCORE PROGRAM
            [
                'title' => 'Hardcore Power & Endurance (6 Days/Week)',
                'description' => json_encode([
                    'focus' => 'High-volume, high-frequency work to break plateaus in both strength and conditioning.',
                    'Day 1' => ['Snatch (Technique)', 'Front Squat (Heavy)', 'Weighted Pull-Ups (Volume)'],
                    'Day 2' => ['Bench Press (Heavy)', 'Weighted Dips (Volume)', 'Burpees (High Volume)'],
                    'Day 3' => ['Deadlift (Heavy)', 'Clean and Jerk (Volume)'],
                    'Day 4' => ['Active Recovery or Light Cardio'],
                    'Day 5' => ['Overhead Press (Heavy)', 'Pistol Squat (Volume)', 'L-Sit (Max Hold)'],
                    'Day 6' => ['Conditioning Circuit (e.g., Kettlebell Snatch, Box Jumps, Single-Arm Dumbbell Thruster)'],
                ]),
                'level' => 'hardcore',
                'duration_weeks' => 10,
                'workout_counts' => 6,
                'equipment_required' => 'Full Gym Access: Barbell, Plates, Squat Rack, Kettlebells, Pull-up Bar',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
