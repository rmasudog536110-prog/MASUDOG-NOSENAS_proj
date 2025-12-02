<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgram;
use App\Models\ProgramEnrollment;
use App\Models\Exercise;
use Illuminate\Http\Request;

class TrainingProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = Exercise::where('is_active', true);

        $difficulty = $request->get('difficulty', 'all');

        if ($difficulty !== 'all') {
            $query->where('difficulty', $difficulty);
        }

        $programs = $query->orderBy('difficulty')->get();

        // Format programs for the view
        $filteredPrograms = $programs->map(function ($program) {
            // Handle description
            $description = $program->description;

            if (is_array($description) && isset($description['overview'])) {
                $descriptionText = $description['overview'];
            } elseif (is_string($description)) {
                $decoded = json_decode($description, true);
                if (is_array($decoded) && isset($decoded['overview'])) {
                    $descriptionText = $decoded['overview'];
                } else {
                    $descriptionText = $description;
                }
            } else {
                $descriptionText = 'Professional training program designed to help you achieve your fitness goals.';
            }

            // Set icon based on level
            $icons = [
                'beginner' => '🌱',
                'intermediate' => '📈',
                'expert' => '🔥',
            ];

            return [
                'id' => $program->id,
                'icon' => $icons[$program->difficulty] ?? '🏋️',
                'title' => $program->difficulty,
                'description' => $descriptionText,
                'equipment' => $program->equipment,
                'level' => ucfirst($program->level),
            ];
        });

        return view('index.programs', [
            'filteredPrograms' => $filteredPrograms,
            'level' => $difficulty,
        ]);
    }

public function show(TrainingProgram $program)
{
    $isEnrolled = auth()->check() && ProgramEnrollment::where('user_id', auth()->id())
        ->where('program_id', $program->id)
        ->where('status', 'active')
        ->exists();

    // Define icons for levels
    $icons = [
        'beginner' => '🌱',
        'intermediate' => '📈',
        'expert' => '🔥',
        'hardcore' => '💪',
    ];

    $level = strtolower($program->level);

    // Description as string (no decoding in Blade)
    $description = 'Professional training program';
    if (!empty($program->description)) {
        if (is_string($program->description)) {
            $decoded = json_decode($program['description'], true);
            if (is_array($decoded) && isset($decoded['overview'])) {
                $description = $decoded['overview'];
            } else {
                $description = $program->description;
            }
        } elseif (is_array($program->description)) {
            $description = $program->description['overview'] ?? 'Professional training program';
        }
    }

    $programData = [
        'id' => $program->id,
        'icon' => $icons[$level] ?? '🏋️',
        'title' => $program->title,
        'description' => $description,
        'level' => ucfirst($level),
        'equipment' => $program->equipment_required ?? 'Basic equipment',
        'duration_weeks' => $program->duration_weeks ?? 0,
        'workout_counts' => $program->workout_counts ?? 0,
    ];

    return view('index.program_detail', [
        'program' => $programData,
        'isEnrolled' => $isEnrolled,
    ]);
}


    public function enroll(TrainingProgram $program)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to enroll in programs.');
        }

        $existing = ProgramEnrollment::where('user_id', auth()->id())
            ->where('program_id', $program->id)
            ->where('status', 'active')
            ->first();

        if ($existing) {
            return back()->with('info', 'You are already enrolled in this program!');
        }

        ProgramEnrollment::create([
            'user_id' => auth()->id(),
            'program_id' => $program->id,
            'enrolled_at' => now(),
            'status' => 'active',
        ]);

        return back()->with('success', 'Successfully enrolled in ' . $program->title . '!');
    }

    private function getLevelIcon($level)
    {
        $icons = [
            'beginner' => '🌱',
            'intermediate' => '📈',
            'advanced' => '⭐',
            'expert' => '🔥',
            'hardcore' => '💪',
        ];

        return $icons[$level] ?? '🏋️';
    }
}
