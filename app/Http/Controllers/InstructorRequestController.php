<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\InstructorRequest;
use App\Models\User;

class InstructorRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new instructor request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required|date_format:H:i',
            'exercise_type' => 'required|string|in:strength,cardio,yoga,pilates,crossfit,bodybuilding,rehabilitation,weight_loss,flexibility,functional',
            'goals' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Check if user already has a pending request
        $existingRequest = InstructorRequest::where('customer_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return redirect()->route('user_dashboard')
                ->with('warning', 'You already have a pending instructor request. Please wait for a response.');
        }

        // Create the instructor request
        $instructorRequest = InstructorRequest::create([
            'customer_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone_number,
            'preferred_date' => $validated['preferred_date'],
            'preferred_time' => $validated['preferred_time'],
            'exercise_type' => $validated['exercise_type'],
            'goals' => $validated['goals'],
            'status' => 'pending',
            'created_by' => $user->id,
        ]);

        // Assign to the first available instructor (you can implement more sophisticated logic)
        $instructor = User::where('role', 'instructor')
            ->where('is_active', true)
            ->first();

        if ($instructor) {
            $instructorRequest->update(['instructor_id' => $instructor->id]);
        }

        return redirect()->route('user_dashboard')
            ->with('success', 'Your instructor request has been submitted successfully! An instructor will contact you soon.');
    }

    /**
     * Get user's instructor requests
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->customerRequests()->with('instructor');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $requests = $query->latest()->paginate(15);

        return view('customer.instructor-requests', compact('requests'));
    }

    /**
     * Show a specific instructor request
     */
    public function show(InstructorRequest $instructorRequest)
    {
        $this->authorizeView($instructorRequest);

        $instructorRequest->load('instructor');

        return view('customer.instructor-request-details', compact('instructorRequest'));
    }

    /**
     * Cancel an instructor request
     */
    public function cancel(InstructorRequest $instructorRequest)
    {
        $this->authorizeManage($instructorRequest);

        if ($instructorRequest->status !== 'pending') {
            return redirect()->route('customer.instructor-requests')
                ->with('error', 'Only pending requests can be cancelled.');
        }

        $instructorRequest->update(['status' => 'cancelled']);

        return redirect()->route('customer.instructor-requests')
            ->with('success', 'Your instructor request has been cancelled.');
    }

    /**
     * Check if user can view the request
     */
    private function authorizeView(InstructorRequest $request): bool
    {
        $user = Auth::user();
        
        // Customer who made the request
        if ($request->customer_id === $user->id) {
            return true;
        }

        // Assigned instructor
        if ($request->instructor_id === $user->id && $user->isInstructor()) {
            return true;
        }

        // Admin access
        if ($user->hasAdminAccess()) {
            return true;
        }

        abort(403, 'Unauthorized access to this request.');
    }

    /**
     * Check if user can manage the request
     */
    private function authorizeManage(InstructorRequest $request): bool
    {
        $user = Auth::user();

        // Customer who made the request can cancel
        if ($request->customer_id === $user->id) {
            return true;
        }

        // Admin access
        if ($user->hasAdminAccess()) {
            return true;
        }

        abort(403, 'Unauthorized to manage this request.');
    }
}