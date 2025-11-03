<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgram;
use App\Models\ProgramEnrollment;
use Illuminate\Http\Request;

class TrainingProgramController extends Controller
{

    public function index(Request $request)
    {
        $query = TrainingProgram::where('is_active', true);
        
        $filter = $request->get('level', 'all');
        
        if ($filter !== 'all') {
            $query->where('level', $filter);
        }
        
        $programs = $query->orderBy('level')->get();
        
        // Format programs for the view
        $filteredPrograms = $programs->map(function($program) {
            // Handle description - it's cast as array in model
            $description = $program->description;
            
            if (is_array($description) && isset($description['overview'])) {
                $descriptionText = $description['overview'];
            } elseif (is_string($description)) {
                // Try to decode if it's a JSON string
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
                'advanced' => '⭐',
                'expert' => '🔥',
                'hardcore' => '💪'
            ];
            
            return [
                'id' => $program->id,
                'icon' => $icons[$program->level] ?? '🏋️',
                'title' => $program->title,
                'description' => $descriptionText,
                'duration' => $program->duration_weeks . ' weeks',
                'workouts' => $program->workout_counts . '/week',
                'equipment' => $program->equipment_required ?? 'Basic equipment',
                'level' => ucfirst($program->level),
            ];
        });

        return view('index.programs', [
            'filteredPrograms' => $filteredPrograms,
            'filter' => $filter
        ]);
    }
    public function show(TrainingProgram $program)
    {
        // Check if user is enrolled
        $isEnrolled = auth()->check() && ProgramEnrollment::where('user_id', auth()->id())
            ->where('program_id', $program->id)
            ->where('status', 'active')
            ->exists();

        // Format program data
        $programData = [
            'id' => $program->id,
            'title' => $program->title,
            'description' => is_array($program->description) && isset($program->description['overview'])
                ? $program->description['overview']
                : (is_string($program->description) ? $program->description : 'Professional training program'),
            'level' => $program->level,
            'duration' => $program->duration_weeks . ' weeks',
            'workouts' => $program->workout_counts . '/week',
            'equipment' => $program->equipment_required ?? 'Basic equipment',
            'icon' => $this->getLevelIcon($program->level),
        ];

        return view('index.program_detail', [
            'program' => $programData,
            'isEnrolled' => $isEnrolled,
            'programModel' => $program
        ]);
    }

    public function enroll(TrainingProgram $program)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to enroll in programs.');
        }

        // Check if already enrolled
        $existing = ProgramEnrollment::where('user_id', auth()->id())
            ->where('program_id', $program->id)
            ->where('status', 'active')
            ->first();

        if ($existing) {
            return back()->with('info', 'You are already enrolled in this program!');
        }

        // Create enrollment record
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
            'hardcore' => '💪'
        ];

        return $icons[$level] ?? '🏋️';
    }
}
