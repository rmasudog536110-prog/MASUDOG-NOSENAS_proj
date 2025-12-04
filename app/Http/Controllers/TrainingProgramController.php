<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use App\Models\ProgramEnrollment;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrainingProgramController extends Controller
{
    /**
     * Display a listing of the programs.
     */
    public function index(Request $request)
    {
        // Get all active training programs
        $query = TrainingProgram::where('is_active', true);

        $difficulty = $request->get('difficulty', 'all');

        if ($difficulty !== 'all') {
            $query->where('level', $difficulty);
        }

        $programs = $query->orderBy('level')->get();

        // Format programs for the view
        $formattedPrograms = $programs->map(function ($program) {
            // Handle description
            $description = $program->description;
            $descriptionText = 'Professional training program designed to help you achieve your fitness goals.';

            if (!empty($description)) {
                if (is_string($description)) {
                    $decoded = json_decode($description, true);
                    if (is_array($decoded) && isset($decoded['overview'])) {
                        $descriptionText = $decoded['overview'];
                    } else {
                        $descriptionText = $description;
                    }
                } elseif (is_array($description)) {
                    $descriptionText = $description['overview'] ?? $descriptionText;
                }
            }

            // Set icon based on level
            $icons = [
                'beginner' => '🌱',
                'intermediate' => '📈',
                'advanced' => '⭐',
                'expert' => '🔥',
                'hardcore' => '💪',
            ];

            $level = strtolower($program->level);

            return [
                'id' => $program->id,
                'icon' => $icons[$level] ?? '🏋️',
                'title' => $program->title,
                'description' => $descriptionText,
                'equipment' => $program->equipment_required,
                'level' => ucfirst($level),
                'duration_weeks' => $program->duration_weeks,
                'workout_counts' => $program->workout_counts,
            ];
        });

        return view('index.programs', [
            'filteredPrograms' => $formattedPrograms,
            'level' => $difficulty,
        ]);
    }

    /**
     * Display the specified program.
     */
    public function show($id)
    {
        // Find the program by ID
        $program = TrainingProgram::findOrFail($id);

        // Check if user is enrolled
        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = ProgramEnrollment::where('user_id', auth()->id())
                ->where('program_id', $program->id)
                ->where('status', 'active')
                ->exists();
        }

        // Define icons for levels
        $icons = [
            'beginner' => '🌱',
            'intermediate' => '📈',
            'advanced' => '⭐',
            'expert' => '🔥',
            'hardcore' => '💪',
        ];

        $level = strtolower($program->level);

        // Handle description - decode JSON if needed
        $descriptionData = [];
        $description = $program->description;
        
        if (!empty($description)) {
            if (is_string($description)) {
                // Try to decode JSON
                $decoded = json_decode($description, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $descriptionData = $decoded;
                } else {
                    // If not JSON, treat as overview
                    $descriptionData = ['overview' => $description];
                }
            } elseif (is_array($description)) {
                $descriptionData = $description;
            }
        }
        
        // Set default if empty
        if (empty($descriptionData)) {
            $descriptionData = [
                'overview' => 'Professional training program designed to help you achieve your fitness goals.',
                'monday' => ['Exercise 1', 'Exercise 2', 'Exercise 3'],
                'tuesday' => ['Exercise 1', 'Exercise 2', 'Exercise 3'],
                'wednesday' => ['Rest Day or Active Recovery'],
            ];
        }

        // Prepare program data for view
        $programData = [
            'id' => $program->id,
            'icon' => $icons[$level] ?? '🏋️',
            'title' => $program->title,
            'description' => $descriptionData, // Pass as array
            'level' => ucfirst($level),
            'equipment' => $program->equipment_required ?? 'Basic equipment',
            'duration_weeks' => $program->duration_weeks ?? 12,
            'workout_counts' => $program->workout_counts ?? 36,
            'focus_area' => $program->focus_area ?? 'Full Body',
        ];

        return view('index.program_detail', [
            'program' => $programData, // Singular name for clarity
            'isEnrolled' => $isEnrolled,
        ]);
    }

    /**
     * Enroll the authenticated user in a program.
     */
    public function enroll(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to enroll in programs.');
        }

        $program = TrainingProgram::findOrFail($id);

        // Check if already enrolled
        $existing = ProgramEnrollment::where('user_id', auth()->id())
            ->where('program_id', $program->id)
            ->where('status', 'active')
            ->first();

        if ($existing) {
            return back()->with('info', 'You are already enrolled in this program!');
        }

        // Create enrollment
        ProgramEnrollment::create([
            'user_id' => auth()->id(),
            'program_id' => $program->id,
            'enrolled_at' => now(),
            'status' => 'active',
            'progress' => 0,
            'last_activity' => now(),
        ]);

        return redirect()->route('my-plan.show')->with('success', 'Successfully enrolled in ' . $program->title . '!');
    }

    /**
     * Display the user's current training plan.
     */
    public function myPlan()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your training plan.');
        }

        // Get user's active enrollment
        $enrollment = ProgramEnrollment::with(['program'])
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest('enrolled_at')
            ->first();

        if (!$enrollment) {
            return view('my-plan.empty')->with('info', 'You are not enrolled in any program yet.');
        }

        $program = $enrollment->program;

        // Define icons for levels
        $icons = [
            'beginner' => '🌱',
            'intermediate' => '📈',
            'advanced' => '⭐',
            'expert' => '🔥',
            'hardcore' => '💪',
        ];

        $level = strtolower($program->level);

        // Handle description - decode JSON if needed
        $descriptionData = [];
        $description = $program->description;
        
        if (!empty($description)) {
            if (is_string($description)) {
                // Try to decode JSON
                $decoded = json_decode($description, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $descriptionData = $decoded;
                } else {
                    // If not JSON, treat as overview
                    $descriptionData = ['overview' => $description];
                }
            } elseif (is_array($description)) {
                $descriptionData = $description;
            }
        }

        // Calculate current day
        $enrolledDate = Carbon::parse($enrollment->enrolled_at);
        $today = Carbon::today();
        $daysSinceEnrollment = $enrolledDate->diffInDays($today);
        $currentDay = $daysSinceEnrollment + 1; // Day 1 is enrollment day

        // Get completed days from enrollment progress
        $completedDays = [];
        if ($enrollment->completed_days) {
            $completedDays = json_decode($enrollment->completed_days, true);
        }

        // Prepare workout schedule
        $workoutSchedule = [];
        $dayCounter = 1;
        
        // Extract workout days from description
        foreach ($descriptionData as $dayName => $exercises) {
            if ($dayName !== 'overview' && $dayName !== 'focus' && $dayName !== 'tips' && $dayName !== 'notes' && is_array($exercises)) {
                $workoutSchedule[] = [
                    'day_number' => $dayCounter,
                    'day_name' => ucfirst($dayName),
                    'exercises' => $exercises,
                    'completed' => in_array($dayName, $completedDays),
                    'is_current' => $dayCounter == $currentDay,
                ];
                $dayCounter++;
            }
        }

        // Calculate progress
        $totalDays = count($workoutSchedule);
        $completedCount = count($completedDays);
        $progressPercentage = $totalDays > 0 ? ($completedCount / $totalDays) * 100 : 0;

        // Update enrollment progress if needed
        if ($enrollment->progress != $progressPercentage) {
            $enrollment->progress = $progressPercentage;
            $enrollment->last_activity = now();
            $enrollment->save();
        }

        // Prepare program data
        $programData = [
            'id' => $program->id,
            'icon' => $icons[$level] ?? '🏋️',
            'title' => $program->title,
            'level' => ucfirst($level),
            'equipment' => $program->equipment_required ?? 'Basic equipment',
            'duration_weeks' => $program->duration_weeks ?? 12,
            'workout_counts' => $totalDays,
            'focus_area' => $program->focus_area ?? 'Full Body',
            'overview' => $descriptionData['overview'] ?? 'Professional training program designed to help you achieve your fitness goals.',
        ];

        return view('my-plan.show', [
            'program' => $programData,
            'enrollment' => $enrollment,
            'workoutSchedule' => $workoutSchedule,
            'currentDay' => $currentDay,
            'progressPercentage' => $progressPercentage,
            'completedCount' => $completedCount,
            'totalDays' => $totalDays,
            'enrolledDate' => $enrolledDate->format('F j, Y'),
        ]);
    }

    /**
     * Mark a day as completed.
     */
    public function completeDay(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to update your plan.');
        }

        $request->validate([
            'program_id' => 'required|exists:training_programs,id',
            'day_name' => 'required|string',
        ]);

        $enrollment = ProgramEnrollment::where('user_id', auth()->id())
            ->where('program_id', $request->program_id)
            ->where('status', 'active')
            ->firstOrFail();

        // Get current completed days
        $completedDays = $enrollment->completed_days ? json_decode($enrollment->completed_days, true) : [];

        // Add the day if not already completed
        if (!in_array($request->day_name, $completedDays)) {
            $completedDays[] = $request->day_name;
            $enrollment->completed_days = json_encode($completedDays);
            
            // Calculate new progress
            $program = $enrollment->program;
            $description = $program->description;
            $descriptionData = [];
            
            if (is_string($description)) {
                $decoded = json_decode($description, true);
                if (is_array($decoded)) {
                    $descriptionData = $decoded;
                }
            }
            
            // Count workout days
            $workoutDayCount = 0;
            foreach ($descriptionData as $key => $value) {
                if ($key !== 'overview' && $key !== 'focus' && $key !== 'tips' && $key !== 'notes' && is_array($value)) {
                    $workoutDayCount++;
                }
            }
            
            $progress = $workoutDayCount > 0 ? (count($completedDays) / $workoutDayCount) * 100 : 0;
            $enrollment->progress = min(100, $progress);
            $enrollment->last_activity = now();
            $enrollment->save();

            return back()->with('success', "Day '{$request->day_name}' marked as completed!");
        }

        return back()->with('info', "Day '{$request->day_name}' was already completed.");
    }

    /**
     * Unenroll from current program.
     */
    public function unenroll(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to update your enrollment.');
        }

        $enrollment = ProgramEnrollment::where('user_id', auth()->id())
            ->where('program_id', $id)
            ->where('status', 'active')
            ->firstOrFail();

        $programTitle = $enrollment->program->title;
        
        // Mark as completed
        $enrollment->status = 'completed';
        $enrollment->completed_at = now();
        $enrollment->save();

        return redirect()->route('programs.index')->with('success', "You have successfully completed '{$programTitle}'!");
    }
}