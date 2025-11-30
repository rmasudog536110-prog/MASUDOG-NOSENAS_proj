<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{

    public function index(Request $request)
    {   

        $query = Exercise::where('is_active', true);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('equipment', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('muscle_group', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Preserve pagination with search parameters
        $exercises = $query->paginate(10)->withQueryString();
        $filter = $request->get('category', 'all');

        return view('index.exercises', [
            'exercises' => $exercises,
            'currentFilters' => $request->only(['difficulty', 'category', 'search']),
            'filter' => $filter,
        ]);
    }

    public function show(Exercise $exercise)
    {
        // Transform database model to array format expected by view
        $exerciseData = [
            'id' => $exercise->id,
            'name' => $exercise->name,
            'description' => $exercise->description,
            'category' => $exercise->category,
            'difficulty' => $exercise->difficulty,
            'equipment' => $exercise->equipment,
            'video_url' => $exercise->video_url,
            'icon' => $exercise->icon ?? '💪',
            'targetMuscles' => ['Full Body'], // Simplified since muscle_group field doesn't exist
            'instructions' => $exercise->instruction ? explode("\n", $exercise->instruction) : ['Follow proper form', 'Breathe steadily', 'Control the movement'],
            'tips' => ['Maintain proper form throughout', 'Start with lighter weights', 'Focus on controlled movements'],
            'variations' => ['Beginner variation available', 'Advanced variation available'],
            'commonMistakes' => ['Rushing through reps', 'Using too much weight', 'Poor form'],
            'defaultSets' => 3,
            'defaultReps' => 12,
            'defaultDuration' => 45,
        ];
        
        return view('index.exercise_details', ['exercise' => $exerciseData]);
    }

    public function filterByDifficulty($difficulty)
{
    // Make sure accepted values
    $allowedLevels = ['beginner', 'intermediate', 'expert'];

    if (!in_array($difficulty, $allowedLevels)) {
        abort(404);
    }

    // Fetch programs filtered by difficulty
    $programs = TrainingProgram::where('is_active', true)
        ->where('level', $difficulty)
        ->get();

    // Transform to the same array format your Blade expects
    $filteredPrograms = $programs->map(function($program) {

        $description = $program->description;
        if (is_array($description) && isset($description['overview'])) {
            $descriptionText = $description['overview'];
        } else {
            $descriptionText = $description;
        }

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
            'level' => $program->level,
            'difficulty' => $program->level
        ];
    });

    return view('index.programs', [
        'filteredPrograms' => $filteredPrograms,
        'filter' => $difficulty
    ]);
}
}