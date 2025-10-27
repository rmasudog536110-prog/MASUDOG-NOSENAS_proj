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
        return view('exercises.details', compact('exercise'));
    }
}


