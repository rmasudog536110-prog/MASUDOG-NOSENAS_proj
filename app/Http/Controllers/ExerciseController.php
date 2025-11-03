<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{

    public function index(Request $request)
    {

        $query = Exercise::where('is_active', true);


        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $exercises = $query->paginate(10);
        $filter = $request->get('category', 'all');

        return view('index.exercises', [
            'exercises' => $exercises,
            'currentFilters' => $request->only(['difficulty', 'category']),
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
            'targetMuscles' => $exercise->muscle_group ? explode(',', $exercise->muscle_group) : ['Full Body'],
            'instructions' => $exercise->instructions ? explode("\n", $exercise->instructions) : ['Follow proper form', 'Breathe steadily', 'Control the movement'],
            'tips' => ['Maintain proper form throughout', 'Start with lighter weights', 'Focus on controlled movements'],
            'variations' => ['Beginner variation available', 'Advanced variation available'],
            'commonMistakes' => ['Rushing through reps', 'Using too much weight', 'Poor form'],
            'defaultSets' => 3,
            'defaultReps' => 12,
            'defaultDuration' => 45,
        ];
        
        return view('index.exercise_details', ['exercise' => $exerciseData]);
    }
}


