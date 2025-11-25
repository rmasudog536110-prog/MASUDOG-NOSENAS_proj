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
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ExerciseController as AdminExerciseController;
use App\Http\Controllers\PasswordResetController;


Route::middleware('guest')->group(function () {

    Route::get('/index', [IndexController::class, 'index'])->name('index');

    Route::get('/', function () {
        return redirect()->route('index');
    });

    Route::get('/register', [UserController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserController::class, 'register'])->name('register.submit');

    Route::get('forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

    Route::get('reset-password/{token}/{email}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
});






Route::middleware('auth')->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Workout logging routes
    Route::resource('workout-logs', WorkoutLogController::class);

    // Subscription payment routes
    Route::get('/subscription/payment/{plan}', [SubscriptionPaymentController::class, 'showPaymentForm'])
        ->name('subscription.payment.form');
    Route::post('/subscription/payment/{plan}', [SubscriptionPaymentController::class, 'submitPayment'])
        ->name('subscription.payment.submit');

    // Customer Instructor Request routes
    Route::prefix('instructor-requests')->name('customer.')->group(function () {
        Route::get('/', [InstructorRequestController::class, 'index'])->name('instructor-requests');
        Route::get('/{instructorRequest}', [InstructorRequestController::class, 'show'])->name('instructor-request-details');
        Route::post('/{instructorRequest}/cancel', [InstructorRequestController::class, 'cancel'])->name('instructor-requests.cancel');
    });

    // Store instructor request (non-prefixed for modal form)
    Route::post('/instructor/requests/store', [InstructorRequestController::class, 'store'])->name('instructor.requests.store');
});

Route::post('/payment/cancel', [UserSubscriptionController::class, 'cancel'])
    ->name('payment.cancel');

Route::get('/payment/cancel', [UserSubscriptionController::class, 'cancel'])
    ->name('payment.cancel');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/index/pending', function () {
    return view('index.pending_dashboard');
})
    ->name('pending_dashboard');

Route::get('/programs', [TrainingProgramController::class, 'index'])
    ->middleware('auth')
    ->name('programs');

Route::get('/programs/{program}', [TrainingProgramController::class, 'show'])
    ->middleware('auth')
    ->name('programs.show');

Route::post('/programs/{program}/enroll', [TrainingProgramController::class, 'enroll'])
    ->middleware('auth')
    ->name('programs.enroll');

Route::get('/exercises', [ExerciseController::class, 'index'])
    ->middleware('auth')
    ->name('exercises');

Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])
    ->middleware('auth')
    ->name('exercises.show');

Route::get('forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

Route::get('reset-password/{token}/{email}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [AdminDashboardController::class, 'editUser'])->name('edit-user');
    Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('update-user');
    Route::post('/users/{user}/subscription', [AdminDashboardController::class, 'updateSubscription'])->name('update-subscription');
    Route::post('/users/{user}/subscription/{subscription}/cancel', [AdminDashboardController::class, 'cancelSubscription'])->name('cancel-subscription');
    Route::post('/users/{user}/toggle-status', [AdminDashboardController::class, 'toggleUserStatus'])->name('toggle-status');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('delete-user');


    // Subscription Payment Approval
    Route::post('/subscriptions/{subscription}/approve', [SubscriptionPaymentController::class, 'approvePayment'])->name('subscriptions.approve');
    Route::post('/subscriptions/{subscription}/reject', [SubscriptionPaymentController::class, 'rejectPayment'])->name('subscriptions.reject');

    // Program Management
    Route::resource('programs', ProgramController::class);
    Route::post('/programs/{program}/toggle', [ProgramController::class, 'toggleStatus'])->name('programs.toggle');

    // Exercise Management
    Route::resource('exercises', AdminExerciseController::class);
});

// Instructor Routes
Route::middleware(['auth', 'instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/requests', [InstructorDashboardController::class, 'getRequests'])->name('requests');
    Route::get('/requests/{instructorRequest}', [InstructorDashboardController::class, 'showRequest'])->name('requests.show');
    Route::post('/requests/{instructorRequest}/accept', [InstructorDashboardController::class, 'acceptRequest'])->name('requests.accept');
    Route::post('/requests/{instructorRequest}/decline', [InstructorDashboardController::class, 'declineRequest'])->name('requests.decline');
    Route::post('/requests/{instructorRequest}/complete', [InstructorDashboardController::class, 'completeRequest'])->name('requests.complete');
});
