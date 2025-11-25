<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeginnerExercisesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('exercises')->insert([
            [
                'name' => 'Jumping Jacks',
                'description' => 'A full-body warm-up exercise.',
                'category' => 'cardio',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Stand upright, jump with legs apart and arms overhead, then return to start.',
                'video_url' => 'https://www.youtube.com/watch?v=dmYwZH_Bnd0', // Updated Link
                'img_url' => 'images/exercises/jumping_jacks.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Bodyweight Squats',
                'description' => 'Improves leg strength and endurance.',
                'category' => 'strength',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Stand with feet shoulder-width apart, lower hips, then return up.',
                'video_url' => 'https://www.youtube.com/watch?v=C_VtbuWnE_c', // Updated Link
                'img_url' => 'images/exercises/bodyweight_squats.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Push-ups (Kneeling)',
                'description' => 'Builds chest, shoulders, and tricep strength, modified for beginners.',
                'category' => 'strength',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Start in a plank position, lower to your knees, then lower your chest toward the floor and push back up.',
                'video_url' => 'https://www.youtube.com/watch?v=aclHkVakuS0', // Updated Link
                'img_url' => 'images/exercises/kneeling_pushups.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Plank',
                'description' => 'Strengthens core and improves stability.',
                'category' => 'core',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Hold a push-up position, resting on your forearms and toes, keeping your body in a straight line.',
                'video_url' => 'https://www.youtube.com/watch?v=ASdvN_XEl_c', // Updated Link
                'img_url' => 'images/exercises/plank.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Crunches',
                'description' => 'Targets the abdominal muscles.',
                'category' => 'core',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Lie on your back, hands behind your head. Lift your shoulders off the floor, engaging your abs, then lower back down.',
                'video_url' => 'https://www.youtube.com/watch?v=Xyd_fa5zoEU', // Updated Link
                'img_url' => 'images/exercises/crunches.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Reverse Lunges',
                'description' => 'Develops balance and strengthens legs and glutes.',
                'category' => 'strength',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Step one foot back and lower your hips until both knees are bent at about a 90-degree angle, then return to the start.',
                'video_url' => 'https://www.youtube.com/watch?v=LQ3b-2-i2ZA', // Updated Link
                'img_url' => 'images/exercises/reverse_lunges.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Glute Bridge',
                'description' => 'Activates the glutes and lower back muscles.',
                'category' => 'strength',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Lie on your back with bent knees. Push through your heels to lift your hips toward the ceiling, forming a straight line from shoulders to knees.',
                'video_url' => 'https://www.youtube.com/watch?v=WH_7832J0IY', // Updated Link
                'img_url' => 'images/exercises/glute_bridge.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'High Knees',
                'description' => 'A great cardio warm-up or conditioning exercise.',
                'category' => 'cardio',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Run in place, bringing your knees up toward your chest as high as possible.',
                'video_url' => 'https://www.youtube.com/watch?v=8WbCr4HsZ24', // Updated Link
                'img_url' => 'images/exercises/high_knees.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Wall Sit',
                'description' => 'Builds isometric strength and endurance in the quads.',
                'category' => 'strength',
                'difficulty' => 'beginner',
                'equipment' => 'wall',
                'instruction' => 'Lean against a wall with your knees bent at a 90-degree angle, as if sitting in an invisible chair. Hold the position.',
                'video_url' => 'https://www.youtube.com/watch?v=mmgqnTtoAq4', // Updated Link
                'img_url' => 'images/exercises/wall_sit.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Bird Dog',
                'description' => 'Improves core stability and balance.',
                'category' => 'core',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Start on all fours. Extend your opposite arm and leg straight out, keeping your back flat. Alternate sides.',
                'video_url' => 'https://www.youtube.com/watch?v=OJrvJY2Pc5M', // Updated Link
                'img_url' => 'images/exercises/bird_dog.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Calf Raises',
                'description' => 'Targets the calf muscles.',
                'category' => 'strength',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Stand straight. Rise up onto the balls of your feet, then slowly lower your heels back down.',
                'video_url' => 'https://www.youtube.com/watch?v=3LICFX-ba_g', // Updated Link
                'img_url' => 'images/exercises/calf_raises.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Mountain Climbers (Slow)',
                'description' => 'A full-body exercise focusing on core and cardio, done at a controlled pace.',
                'category' => 'cardio',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Start in a plank position. Slowly bring one knee toward your chest, then return and alternate with the other knee.',
                'video_url' => 'https://www.youtube.com/watch?v=nmwgirgXLYM', // Updated Link
                'img_url' => 'images/exercises/mountain_climbers_slow.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Lateral Leg Lifts',
                'description' => 'Strengthens the hip abductors and glutes (outer thigh).',
                'category' => 'strength',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Lie on your side. Keeping your leg straight and core tight, lift your top leg toward the ceiling, then slowly lower it.',
                'video_url' => 'https://www.youtube.com/watch?v=qL-JZ2Vak9o', // Updated Link
                'img_url' => 'images/exercises/lateral_leg_lifts.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Arm Circles',
                'description' => 'A dynamic warm-up or cool-down for the shoulders.',
                'category' => 'warmup',
                'difficulty' => 'beginner',
                'equipment' => 'none',
                'instruction' => 'Stand with arms straight out to the sides. Make small, controlled circular motions with your arms, then reverse direction.',
                'video_url' => 'https://www.youtube.com/watch?v=2sj2iVd-4k4', // Updated Link
                'img_url' => 'images/exercises/arm_circles.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Bicep Curl (Bodyweight)',
                'description' => 'Targets the biceps using bodyweight and an anchor.',
                'category' => 'strength',
                'difficulty' => 'beginner',
                'equipment' => 'towel or band (optional)',
                'instruction' => 'Use a towel/band under one foot, holding ends in hands. Curl hands toward shoulders against resistance. Alternatively, use a sturdy table edge (hands under, pull up).',
                'video_url' => 'https://www.youtube.com/watch?v=hJbRp-Z4jxY', // Updated Link
                'img_url' => 'images/exercises/bicep_curl_bodyweight.jpg',
                'is_active' => true,
            ],
        ]);
    }
}