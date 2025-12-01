<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = TrainingProgram::latest()->paginate(20);
        
        $stats = [
            'total' => TrainingProgram::count(),
            'active' => TrainingProgram::where('is_active', true)->count(),
            'inactive' => TrainingProgram::where('is_active', false)->count(),
        ];

        return view('admin.programs.index', compact('programs', 'stats'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function show(TrainingProgram $program)
    {
        return view('admin.programs.show', compact('program'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration_weeks' => 'required|integer|min:1',
            'workout_counts' => 'required|integer|min:1',
            'equipment_required' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        // Convert description to JSON array format
        $validated['description'] = json_encode(['overview' => $validated['description']]);

        TrainingProgram::create($validated);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program created successfully!');
    }

    public function edit(TrainingProgram $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, TrainingProgram $program)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration_weeks' => 'required|integer|min:1',
            'workout_counts' => 'required|integer|min:1',
            'equipment_required' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        // Convert description to JSON array format
        $validated['description'] = json_encode(['overview' => $validated['description']]);

        $program->update($validated);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program updated successfully!');
    }

    public function destroy(TrainingProgram $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program deleted successfully!');
    }

    public function toggleStatus(TrainingProgram $program)
    {
        $program->update(['is_active' => !$program->is_active]);

        return back()->with('success', 'Program status updated!');
    }
}
