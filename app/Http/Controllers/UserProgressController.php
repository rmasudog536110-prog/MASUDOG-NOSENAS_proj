<?php

namespace App\Http\Controllers;

use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProgressController extends Controller
{

    public function index()
    {
        $progress = Auth::user()->progress()
            ->with(['exercise', 'program']) // Eager load related data
            ->orderBy('workout_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('progress.index', compact('progress'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'workout_date' => 'required|date',
            'sets_completed' => 'nullable|integer|min:1',
            'reps_completed' => 'nullable|integer|min:1',
            'duration_minutes' => 'nullable|integer|min:1',
            'weight_used' => 'nullable|numeric|min:0',
            'program_id' => 'nullable|exists:training_programs,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $progress = new UserProgress($request->all());
        $progress->user_id = Auth::id();
        $progress->save();

        return redirect()->route('progress.index')->with('success', 'Workout successfully logged!');
    }
}
