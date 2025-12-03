<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\InstructorRequest;
use App\Models\User;

class InstructorDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isInstructor() && !Auth::user()->hasAdminAccess()) {
                abort(403, 'Access denied. Instructor role required.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $user = Auth::user();

        // Get instructor request statistics
        $stats = [
            'total_requests' => $user->instructorRequests()->count(),
            'pending_requests' => $user->instructorRequests()->where('status', 'pending')->count(),
            'accepted_requests' => $user->instructorRequests()->where('status', 'accepted')->count(),
            'completed_sessions' => $user->instructorRequests()->where('status', 'completed')->count(),
            'this_month_sessions' => $user->instructorRequests()
                ->where('status', 'completed')
                ->whereMonth('completed_at', now()->month)
                ->whereYear('completed_at', now()->year)
                ->count(),
        ];

        // Get recent requests
        $recentRequests = $user->instructorRequests()
            ->with('customer')
            ->latest()
            ->take(10)
            ->get();

        // Get today's scheduled sessions
        $todaySessions = $user->instructorRequests()
            ->with('customer')
            ->whereDate('scheduled_at', today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('scheduled_at')
            ->get();

        // Get upcoming sessions (next 7 days)
        $upcomingSessions = $user->instructorRequests()
            ->with('customer')
            ->whereBetween('scheduled_at', [now(), now()->addDays(7)])
            ->where('status', '!=', 'cancelled')
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        // Get monthly completion data for charts
        $monthlyData = $user->instructorRequests()
            ->selectRaw('MONTH(completed_at) as month, COUNT(*) as count')
            ->where('status', 'completed')
            ->whereYear('completed_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Fill in missing months with 0
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyData[$i])) {
                $monthlyData[$i] = 0;
            }
        }

        // Calculate completion rate
        $completionRate = 0;
        if ($stats['total_requests'] > 0) {
            $completionRate = round(($stats['completed_sessions'] / $stats['total_requests']) * 100, 1);
        }

        return view('instructor_dashboard', compact(
            'stats',
            'recentRequests',
            'todaySessions',
            'upcomingSessions',
            'monthlyData',
            'completionRate'
        ));
    }

    /**
     * Show a specific instructor request
     */
    public function showRequest(InstructorRequest $instructorRequest)
    {
        $this->authorizeViewRequest($instructorRequest);

        $instructorRequest->load('customer');

        return view('instructor.request-details', compact('instructorRequest'));
    }

    /**
     * Accept an instructor request
     */
    public function acceptRequest(InstructorRequest $instructorRequest, Request $request)
    {
        $this->authorizeManageRequest($instructorRequest);

        $validated = $request->validate([
            'instructor_notes' => 'nullable|string|max:500',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $instructorRequest->update([
            'status' => 'accepted',
            'instructor_id' => Auth::id(),
            'instructor_notes' => $validated['instructor_notes'],
            'scheduled_at' => $validated['scheduled_at'] ?? $instructorRequest->scheduled_at,
        ]);

        return redirect()->route('instructor.requests.show', $instructorRequest)
            ->with('success', 'Request accepted successfully!');
    }

    /**
     * Decline an instructor request
     */
    public function declineRequest(InstructorRequest $instructorRequest, Request $request)
    {
        $this->authorizeManageRequest($instructorRequest);

        $validated = $request->validate([
            'instructor_notes' => 'required|string|max:500',
        ]);

        $instructorRequest->update([
            'status' => 'declined',
            'instructor_id' => Auth::id(),
            'instructor_notes' => $validated['instructor_notes'],
        ]);

        return redirect()->route('instructor.requests.show', $instructorRequest)
            ->with('success', 'Request declined successfully.');
    }

    /**
     * Mark a session as completed
     */
    public function completeRequest(InstructorRequest $instructorRequest, Request $request)
    {
        $this->authorizeManageRequest($instructorRequest);

        $validated = $request->validate([
            'instructor_notes' => 'nullable|string|max:1000',
        ]);

        $instructorRequest->update([
            'status' => 'completed',
            'completed_at' => now(),
            'instructor_notes' => $validated['instructor_notes'],
        ]);

        return redirect()->route('instructor_dashboard')
            ->with('success', 'Session marked as completed!');
    }

    /**
     * Get all requests with filtering options
     */
    public function getRequests(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->instructorRequests()->with('customer');

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

        // Search by customer name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $requests = $query->latest()->paginate(15);

        return response()->json([
            'requests' => $requests,
            'filters' => $request->only(['status', 'date_from', 'date_to', 'search'])
        ]);
    }

    /**
     * Check if user can view a specific request
     */
    private function authorizeViewRequest(InstructorRequest $request): bool
    {
        if (Auth::user()->hasAdminAccess()) {
            return true;
        }

        return $request->instructor_id === Auth::id() || $request->customer_id === Auth::id();
    }

    /**
     * Check if user can manage a specific request
     */
    private function authorizeManageRequest(InstructorRequest $request): bool
    {
        if (Auth::user()->hasAdminAccess()) {
            return true;
        }

        return $request->instructor_id === Auth::id();
    }
}