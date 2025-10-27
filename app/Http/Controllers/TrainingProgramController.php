<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use Illuminate\Http\Request;

class TrainingProgramController extends Controller
{

    public function index()
    {
        $programs = TrainingProgram::where('is_active', true)
            ->orderBy('level')
            ->get();

        return view('index.programs', [
            'filteredPrograms' => $programs,
            'filter' => 'all'
        ]);
    }
    public function show(TrainingProgram $program)
    {
        $programDetails = $program->description;

        return view('index.program_detail', compact('program', 'programDetails'));
    }
}
