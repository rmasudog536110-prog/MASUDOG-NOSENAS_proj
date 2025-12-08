<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $icons = [
            'beginner' => '🌱',
            'intermediate' => '📈',
            'advanced' => '⭐',
            'expert' => '🔥',
            'hardcore' => '💪'
        ];

        $search = $request->get('search');

        $query = Exercise::query();

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('muscle_group', 'like', '%' . $search . '%');
            });
        }

        $exercises = $query->orderBy('name')->paginate(10)->withQueryString();
        
        return view('admin.exercises.index', compact('exercises', 'icons', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.exercises.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:warmup,strength,cardio,flexibility,plyometrics,functional,core',
            'difficulty' => 'required|in:beginner,intermediate,expert',
            'equipment' => 'required|string|max:255',
            'muscle_group' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'video_url' => 'nullable|url',
            'icon' => 'nullable|string|max:50',
        ]);

        Exercise::create($validated);

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
        return view('admin.exercises.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exercise $exercise)
    {
        return view('admin.exercises.edit', compact('exercise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exercise $exercise)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:warmup,strength,cardio,flexibility,plyometrics,functional,core',
            'difficulty' => 'required|in:beginner,intermediate,expert',
            'equipment' => 'required|string|max:255',
            'muscle_group' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'video_url' => 'nullable|url',
            'icon' => 'nullable|string|max:50',
        ]);

        $exercise->update($validated);

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise deleted successfully!');
    }
}
