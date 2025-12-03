<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controllerwe
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'customer')->count(),
            'total_revenue' => PaymentTransaction::where('status', 'approved')->sum('amount'),
            'revenue_this_month' => PaymentTransaction::where('status', 'approved')
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
            'pending_payments' => PaymentTransaction::where('status', 'pending')->count(),
        ];

        $stats['active_subscriptions'] = UserSubscription::where('status', 'active')
            ->where('end_date', '>', now())
            ->count();

        $stats['new_customers_today'] = User::where('role', 'customer')
                ->whereDate('created_at', today())
                ->count();

        $stats['new_customers_month'] = User::where('role', 'customer')
                ->whereMonth('created_at', now()->month)
                ->count();

        $stats['expiring_soon'] = UserSubscription::where('status', 'active')
            ->whereBetween('end_date', [now(), now()->addDays(7)])
            ->count();

        $stats['monthly_revenue'] = PaymentTransaction::where('status', 'approved')
            ->whereMonth('updated_at', now()->month)    
            ->sum('amount');

        $stats['oldest_pending'] = PaymentTransaction::where('status', 'pending')
            ->oldest()
            ->first()
            ?->created_at?->diffForHumans() ?? 0;

        $recentUsers = User::where('role', 'customer')
            ->latest()
            ->take(5)
            ->get();

        $instructor = User::where('role', 'instructor')
            ->latest()
            ->take(5)
            ->get();

        // Get pending payment subscriptions
        $pendingPayments = UserSubscription::where('status', 'null')
            ->with(['user', 'plan', 'payments'])
            ->latest()
            ->get();

        return view('admin_dashboard', compact('stats', 'recentUsers', 'pendingPayments', 'instructor'));
    }

    public function users()
    {
        $users = User::where('role', 'customer')
            ->with(['subscriptions.plan'])
            ->latest()
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function editUser(User $user)
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();
        
        // Get active subscription (not expired and status is active)
        $activeSub = $user->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->latest()
            ->first();

        return view('admin.edit-user', compact('user', 'plans', 'activeSub'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'is_active' => 'required|boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully!');
    }

    public function updateSubscription(Request $request, User $user)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'action' => 'required|in:add,update',
            'subscription_id' => 'nullable|exists:user_subscriptions,id',
        ]);

        $plan = SubscriptionPlan::find($validated['plan_id']);

        if ($validated['action'] === 'update' && $validated['subscription_id']) {
            // Update existing subscription
            $subscription = UserSubscription::findOrFail($validated['subscription_id']);
            
            // Verify subscription belongs to this user
            if ($subscription->user_id !== $user->id) {
                return back()->with('error', 'Invalid subscription!');
            }

            $subscription->update([
                'plan_id' => $validated['plan_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => 'active',
            ]);

            $message = 'Subscription updated successfully!';
        } else {
            // Deactivate all previous active subscriptions
            UserSubscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'cancelled']);

            // Create new subscription
            UserSubscription::create([
                'user_id' => $user->id,
                'plan_id' => $validated['plan_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => 'active',
            ]);

            $message = 'New subscription added successfully!';
        }

        return redirect()->route('admin.edit-user', $user)
            ->with('success', $message);
    }

    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', 'User status updated!');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully!');
    }

    public function cancelSubscription(User $user, UserSubscription $subscription)
    {
        // Verify subscription belongs to this user
        if ($subscription->user_id !== $user->id) {
            return back()->with('error', 'Invalid subscription!');
        }

        // Cancel the subscription
        $subscription->update(['status' => 'cancelled']);

        return back()->with('success', 'Subscription cancelled successfully!');
    }
}
