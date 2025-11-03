<?php

namespace App\Http\Controllers;

use App\Models\WorkoutLog;
use App\Models\Exercise;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->workoutLogs()
            ->with(['exercise', 'trainingProgram'])
            ->orderBy('workout_date', 'desc');

        // Apply filters
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'week':
                    $query->whereBetween('workout_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('workout_date', now()->month)
                          ->whereYear('workout_date', now()->year);
                    break;
            }
        }

        $workouts = $query->paginate(20);

        // Calculate stats
        $stats = [
            'total_workouts' => Auth::user()->workoutLogs()->count(),
            'this_week' => Auth::user()->workoutLogs()
                ->whereBetween('workout_date', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'this_month' => Auth::user()->workoutLogs()
                ->whereMonth('workout_date', now()->month)
                ->whereYear('workout_date', now()->year)
                ->count(),
            'total_calories' => Auth::user()->workoutLogs()->sum('calories_burned') ?? 0,
        ];

        return view('workout-logs.index', compact('workouts', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exercises = Exercise::orderBy('name')->get();
        $programs = TrainingProgram::orderBy('title')->get();
        
        return view('workout-logs.create', compact('exercises', 'programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exercise_id' => 'nullable|exists:exercises,id',
            'training_program_id' => 'nullable|exists:training_programs,id',
            'workout_date' => 'required|date|before_or_equal:today',
            'sets' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:1',
            'weight' => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'distance' => 'nullable|numeric|min:0',
            'calories_burned' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $validated['user_id'] = Auth::id();

        WorkoutLog::create($validated);

        return redirect()->route('workout-logs.index')
            ->with('success', 'Workout logged successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkoutLog $workoutLog)
    {
        // Ensure user owns this workout log
        if ($workoutLog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $workoutLog->load(['exercise', 'trainingProgram']);
        
        return view('workout-logs.show', compact('workoutLog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkoutLog $workoutLog)
    {
        // Ensure user owns this workout log
        if ($workoutLog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $exercises = Exercise::orderBy('name')->get();
        $programs = TrainingProgram::orderBy('title')->get();
        
        return view('workout-logs.edit', compact('workoutLog', 'exercises', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkoutLog $workoutLog)
    {
        // Ensure user owns this workout log
        if ($workoutLog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'exercise_id' => 'nullable|exists:exercises,id',
            'training_program_id' => 'nullable|exists:training_programs,id',
            'workout_date' => 'required|date|before_or_equal:today',
            'sets' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:1',
            'weight' => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'distance' => 'nullable|numeric|min:0',
            'calories_burned' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $workoutLog->update($validated);

        return redirect()->route('workout-logs.index')
            ->with('success', 'Workout updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutLog $workoutLog)
    {
        // Ensure user owns this workout log
        if ($workoutLog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $workoutLog->delete();

        return redirect()->route('workout-logs.index')
            ->with('success', 'Workout deleted successfully!');
    }
}
