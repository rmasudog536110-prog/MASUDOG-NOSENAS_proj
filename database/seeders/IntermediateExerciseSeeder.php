<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntermediateExerciseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('exercises')->insert([
            // -------------------------------------------------------
            // Core Compound Movements
            // -------------------------------------------------------
            [
                'name' => 'Push-Ups',
                'description' => 'A classic upper body exercise for chest, shoulders, and triceps.',
                'category' => 'strength',
                'difficulty' => 'intermediate',
                'equipment' => 'none',
                'instruction' => 'Lower your body until your chest nearly touches the floor, maintaining a straight line, then push back up.',
                'video_url' => 'https://www.youtube.com/watch?v=_l3ySVKYVJ8', // Nuffield Health: Push Ups (36s)
                'img_url' => 'images/exercises/pushups.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Lunges',
                'description' => 'A functional exercise targeting legs and glutes.',
                'category' => 'functional',
                'difficulty' => 'intermediate',
                'equipment' => 'none',
                'instruction' => 'Step forward and lower hips until both knees are bent at 90 degrees, ensuring the front knee stays over the ankle.',
                'video_url' => 'https://www.youtube.com/watch?v=MxfTNXSgFJA', // Nuffield Health: Lunges (41s)
                'img_url' => 'images/exercises/lunges.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Dumbbell Bench Press',
                'description' => 'Classic exercise for chest, shoulders, and triceps.',
                'category' => 'strength',
                'difficulty' => 'intermediate',
                'equipment' => 'dumbbells, bench',
                'instruction' => 'Lie on a bench and press the dumbbells straight up until your arms are fully extended. Lower them slowly back to the start.',
                'video_url' => 'https://www.youtube.com/watch?v=VmB1G1K7v94', // ScottHermanFitness: DB Bench Press (Short Demo)
                'img_url' => 'images/exercises/dumbbell_bench_press.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Dumbbell Rows (Single-Arm)',
                'description' => 'Builds back thickness, lats, and biceps.',
                'category' => 'strength',
                'difficulty' => 'intermediate',
                'equipment' => 'dumbbell, bench',
                'instruction' => 'Rest one knee and hand on a bench. Pull a dumbbell up toward your chest, squeezing your shoulder blade, then lower it slowly.',
                'video_url' => 'https://www.youtube.com/watch?v=6id82yO5jMI', // Nuffield Health: One Arm Row (33s)
                'img_url' => 'images/exercises/dumbbell_row.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Overhead Press (Dumbbell)',
                'description' => 'Targets shoulders and triceps for upper body strength.',
                'category' => 'strength',
                'difficulty' => 'intermediate',
                'equipment' => 'dumbbells',
                'instruction' => 'Stand or sit, holding dumbbells at shoulder height. Press them straight overhead until your arms are locked out, then return slowly.',
                'video_url' => 'https://www.youtube.com/watch?v=M2rwvNhTOu0', // ScottHerman: Seated DB Press (Short)
                'img_url' => 'images/exercises/dumbbell_overhead_press.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Russian Twist',
                'description' => 'A dynamic core exercise targeting the obliques.',
                'category' => 'core',
                'difficulty' => 'intermediate',
                'equipment' => 'none or dumbbell/plate',
                'instruction' => 'Sit with knees bent and lean back slightly, lifting your feet. Twist your torso side to side, touching the floor (or weight) on each side.',
                'video_url' => 'https://www.youtube.com/watch?v=wkD8rjkodUI', // P4P: Russian Twist (Still best short demo)
                'img_url' => 'images/exercises/russian_twist.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Burpees',
                'description' => 'A high-intensity, full-body cardiovascular and strength exercise.',
                'category' => 'cardio',
                'difficulty' => 'intermediate',
                'equipment' => 'none',
                'instruction' => 'Squat down, kick feet back into a plank, perform a push-up (optional), jump feet back to squat, and then jump up, reaching overhead.',
                'video_url' => 'https://www.youtube.com/watch?v=AuXNn17ZkXU', // Nuffield Health: Burpees (45s)
                'img_url' => 'images/exercises/burpees.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Single-Leg Glute Bridge',
                'description' => 'Unilateral glute exercise that increases difficulty and targets core stability.',
                'category' => 'strength',
                'difficulty' => 'intermediate',
                'equipment' => 'none',
                'instruction' => 'Lie on your back with one leg extended. Push through the heel of the planted foot to lift your hips toward the ceiling, keeping them level.',
                'video_url' => 'https://www.youtube.com/watch?v=Lx_V3a43QO0', // Nuffield Health: Single Leg Bridge (30s)
                'img_url' => 'images/exercises/single_leg_glute_bridge.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Step-Ups',
                'description' => 'Unilateral exercise for leg strength and balance.',
                'category' => 'functional',
                'difficulty' => 'intermediate',
                'equipment' => 'bench or box',
                'instruction' => 'Step onto a bench or box with one foot, driving your body up until the standing leg is straight. Step back down and alternate sides.',
                'video_url' => 'https://www.youtube.com/watch?v=wC9oRGoK4v4', // Nuffield Health: Step Ups (33s)
                'img_url' => 'images/exercises/step_ups.jpg',
                'is_active' => true,
            ],

            // -------------------------------------------------------
            // Gym Equipment / Advanced Bodyweight
            // -------------------------------------------------------
            [
                'name' => 'Goblet Squat',
                'description' => 'A kettlebell or dumbbell squat variation emphasizing depth and core engagement.',
                'category' => 'strength',
                'difficulty' => 'intermediate',
                'equipment' => 'dumbbell or kettlebell',
                'instruction' => 'Hold a weight vertically against your chest. Squat down deep, keeping your chest up and elbows inside your knees, then stand back up.',
                'video_url' => 'https://www.youtube.com/watch?v=MeIiIdhvXT4', // ScottHerman: Goblet Squat (Short)
                'img_url' => 'images/exercises/goblet_squat.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Dumbbell Romanian Deadlift (RDL)',
                'description' => 'Targets the hamstrings and glutes while improving hip hinge mobility.',
                'category' => 'strength',
                'difficulty' => 'intermediate',
                'equipment' => 'dumbbells',
                'instruction' => 'Hold dumbbells in front of your thighs. Hinge at the hips, lowering the weights while keeping your back straight and knees slightly bent, then return to vertical.',
                'video_url' => 'https://www.youtube.com/watch?v=JCXUYuzwNrM', // ScottHerman: DB RDL (Short)
                'img_url' => 'images/exercises/dumbbell_rdl.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Face Pulls (Band)',
                'description' => 'Targets rear deltoids and upper back for shoulder health and posture.',
                'category' => 'strength',
                'difficulty' => 'intermediate',
                'equipment' => 'resistance band or cable machine',
                'instruction' => 'Hold a band or cable rope. Pull the attachment toward your face, externally rotating your shoulders so your elbows flare out.',
                'video_url' => 'https://www.youtube.com/watch?v=0Po47vvj9g4', // ScottHerman: Face Pull (Concise)
                'img_url' => 'images/exercises/face_pulls.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Box Jumps',
                'description' => 'Plyometric exercise to build explosive power in the legs.',
                'category' => 'plyometrics',
                'difficulty' => 'intermediate',
                'equipment' => 'box or bench',
                'instruction' => 'Stand in front of a box. Swing your arms and jump explosively onto the box, landing softly. Step back down.',
                'video_url' => 'https://www.youtube.com/watch?v=52r_Ul5k03g', // Nuffield: Box Jumps (25s)
                'img_url' => 'images/exercises/box_jumps.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Hanging Knee Raise',
                'description' => 'Advanced core work focusing on lower abs and grip strength.',
                'category' => 'core',
                'difficulty' => 'intermediate',
                'equipment' => 'pull-up bar',
                'instruction' => 'Hang from a pull-up bar. Keeping your core tight, lift your knees up toward your chest, then slowly lower them.',
                'video_url' => 'https://www.youtube.com/watch?v=jW01T2W6Ojc', // GymVisual: Hanging Knee Raise (Animated, clean)
                'img_url' => 'images/exercises/hanging_knee_raise.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Plank Hip Dips',
                'description' => 'A dynamic core variation targeting the obliques with increased movement.',
                'category' => 'core',
                'difficulty' => 'intermediate',
                'equipment' => 'none',
                'instruction' => 'Start in a forearm plank. Rotate your hips to dip one side almost to the floor, then return and dip the other side, alternating.',
                'video_url' => 'https://www.youtube.com/watch?v=Q7pE9C3R3n8', // Bowflex: Plank Hip Dips (Short)
                'img_url' => 'images/exercises/plank_hip_dips.jpg',
                'is_active' => true,
            ],
        ]);
    }
}