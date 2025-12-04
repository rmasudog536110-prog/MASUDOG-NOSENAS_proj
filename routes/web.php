<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PaymentTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\TrainingProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProgressController;
use App\Http\Controllers\UserSubscriptionController;
use App\Http\Controllers\WorkoutLogController;
use App\Http\Controllers\InstructorRequestController;
use App\Http\Controllers\InstructorDashboardController;
use App\Http\Controllers\SubscriptionPaymentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ExerciseController as AdminExerciseController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ReportController;


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/index', [IndexController::class, 'index'])->name('index');

    Route::get('/register', [UserController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserController::class, 'registerUser'])->name('register.submit');


    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login.submit');

});


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /**
     * USER PROFILE
     */
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /**
     * WORKOUT LOGS (User)
     */
    Route::resource('workout-logs', WorkoutLogController::class);


    /**
     * SUBSCRIPTION PAYMENT (User)
     */
    Route::prefix('subscription/payment')->group(function () {
        Route::get('/{plan}', [SubscriptionPaymentController::class, 'showPaymentForm'])
            ->name('subscription.payment.form');

        Route::post('/{plan}', [SubscriptionPaymentController::class, 'submitPayment'])
            ->name('subscription.payment.submit');
    });


    /**
     * INSTRUCTOR REQUESTS (User)
     */
    Route::prefix('instructor-requests')->name('customer.')->group(function () {

        Route::get('/', [InstructorRequestController::class, 'index'])
            ->name('instructor-requests');

        Route::get('/{instructorRequest}', [InstructorRequestController::class, 'show'])
            ->name('instructor-request-details');

        Route::post('/{instructorRequest}/cancel', [InstructorRequestController::class, 'cancel'])
            ->name('instructor-requests.cancel');
    });

    Route::post('/instructor/requests/store', [InstructorRequestController::class, 'store'])
        ->name('instructor.requests.store');


    /**
     * USER DASHBOARD
     */
    Route::get('/user_dashboard', [DashboardController::class, 'index'])->name('user_dashboard');

Route::prefix('programs')->group(function () {
    Route::get('/', [TrainingProgramController::class, 'index'])->name('programs.index');
    Route::get('/{id}', [TrainingProgramController::class, 'show'])->name('programs.show');
    Route::post('/{id}/enroll', [TrainingProgramController::class, 'enroll'])
         ->name('programs.enroll')
         ->middleware('auth');
});

// My Plan routes - Protected (require authentication)
Route::middleware(['auth','customer'])->prefix('my-plan')->group(function () {
    Route::get('/', [TrainingProgramController::class, 'myPlan'])->name('my-plan.show');
    Route::post('/complete-day', [TrainingProgramController::class, 'completeDay'])->name('my-plan.complete-day');
    Route::post('/{id}/unenroll', [TrainingProgramController::class, 'unenroll'])->name('my-plan.unenroll');
});   

    /**
     * EXERCISES (User)
     */
    Route::get('/exercises', [ExerciseController::class, 'index'])
        ->name('exercises.index');

    Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])
        ->name('exercises.show');
});


/*
|--------------------------------------------------------------------------
| Public Routes (outside middleware)
|--------------------------------------------------------------------------
*/

Route::post('/payment/cancel', [UserSubscriptionController::class, 'cancel'])->name('payment.cancel');

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

// Pending dashboard
Route::get('/index/pending', function () {
    return view('index.pending_dashboard');
})->name('pending_dashboard');

Route::get('forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

Route::get('reset-password/{token}/{email}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/admin_dashboard', [AdminDashboardController::class, 'index'])->name('admin_dashboard');

    // Users
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [AdminDashboardController::class, 'editUser'])->name('edit-user');
    Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('update-user');
    Route::post('/users/{user}/subscription', [AdminDashboardController::class, 'updateSubscription'])->name('update-subscription');
    Route::post('/users/{user}/subscription/{subscription}/cancel', [AdminDashboardController::class, 'cancelSubscription'])->name('cancel-subscription');
    Route::post('/users/{user}/toggle-status', [AdminDashboardController::class, 'toggleUserStatus'])->name('toggle-status');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('delete-user');
    
    // Admin Program Management
    Route::resource('programs', ProgramController::class);

    // Custom toggle status
    Route::post('/programs/{program}/toggle', [ProgramController::class, 'toggleStatus'])
        ->name('programs.toggle');
        // Exercises
    Route::resource('exercises', AdminExerciseController::class);


    // Approvals
    Route::post('/subscriptions/{subscription}/approve', [SubscriptionPaymentController::class, 'approvePayment'])->name('subscriptions.approve');
    Route::post('/subscriptions/{subscription}/reject', [SubscriptionPaymentController::class, 'rejectPayment'])->name('subscriptions.reject');
});


/*
|--------------------------------------------------------------------------
| Instructor Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'instructor'])->prefix('instructor')->name('instructor.')->group(function () {

    Route::get('/instructor_dashboard', [InstructorDashboardController::class, 'index'])->name('instructor_dashboard');
    Route::get('/requests', [InstructorDashboardController::class, 'getRequests'])->name('requests');
    Route::get('/requests/{instructorRequest}', [InstructorDashboardController::class, 'showRequest'])->name('requests.show');
    Route::post('/requests/{instructorRequest}/accept', [InstructorDashboardController::class, 'acceptRequest'])->name('requests.accept');
    Route::post('/requests/{instructorRequest}/decline', [InstructorDashboardController::class, 'declineRequest'])->name('requests.decline');
    Route::post('/requests/{instructorRequest}/complete', [InstructorDashboardController::class, 'completeRequest'])->name('requests.complete');
});


/*
|--------------------------------------------------------------------------
| Reports (Admin)
|-------------------------------------------------------------------------- 
*/
Route::prefix('admin/reports')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/active-members', [ReportController::class, 'activeMembers'])->name('reports.active_members');
    Route::get('/expiring-soon', [ReportController::class, 'expiringSoon'])->name('reports.expiring_soon');
    Route::get('/payments', [ReportController::class, 'payments'])->name('reports.payments');
    Route::get('/pending-payments', [ReportController::class, 'pendingPayments'])->name('reports.pending_payments');
    Route::get('/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/subscription-status', [ReportController::class, 'subscriptionStatus'])->name('reports.subscription_status');
    Route::get('/full', [ReportController::class, 'full'])->name('reports.full_report');

    // PDF Export
    Route::get('/active_members_pdf', [ReportController::class, 'activeMembersPDF'])->name('reports.active_members_pdf');
    Route::get('/expiring_soon_pdf', [ReportController::class, 'expiringSoonPDF'])->name('reports.expiring_soon_pdf');
    Route::get('/payments_pdf', [ReportController::class, 'paymentsPDF'])->name('reports.payments_pdf');
    Route::get('/pending_payments_pdf', [ReportController::class, 'pendingPaymentsPDF'])->name('reports.pending_payments_pdf');
    Route::get('/full_report_pdf', [ReportController::class, 'fullReportPDF'])->name('reports.full_report_pdf');
});
