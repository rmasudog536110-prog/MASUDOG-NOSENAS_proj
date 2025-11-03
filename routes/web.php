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





Route::middleware('guest')->group(function (){

Route::get('/index', [IndexController::class, 'index'])->name('index');

Route::get('/', function () {
    return redirect()->route('index');
});

Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function(){    
    
    // Payment routes
    Route::get('/payment/{subscription_id}', [PaymentTransactionController::class, 'show'])->name('payment.payment');
    Route::post('/payment/{subscription_id}', [PaymentTransactionController::class, 'process'])->name('payment.process');
    Route::get('/payment-history', [PaymentTransactionController::class, 'index'])->name('payment.history');

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
    Route::get('/subscription/payment/{plan}', [App\Http\Controllers\SubscriptionPaymentController::class, 'showPaymentForm'])->name('subscription.payment.form');
    Route::post('/subscription/payment/{plan}', [App\Http\Controllers\SubscriptionPaymentController::class, 'submitPayment'])->name('subscription.payment.submit');

});


Route::get('/logout', [UserController::class, 'logout'])->name('logout  ');
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

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

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\DashboardController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\DashboardController::class, 'editUser'])->name('edit-user');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\DashboardController::class, 'updateUser'])->name('update-user');
    Route::post('/users/{user}/subscription', [App\Http\Controllers\Admin\DashboardController::class, 'updateSubscription'])->name('update-subscription');
    Route::post('/users/{user}/subscription/{subscription}/cancel', [App\Http\Controllers\Admin\DashboardController::class, 'cancelSubscription'])->name('cancel-subscription');
    Route::post('/users/{user}/toggle-status', [App\Http\Controllers\Admin\DashboardController::class, 'toggleUserStatus'])->name('toggle-status');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\DashboardController::class, 'deleteUser'])->name('delete-user');
    
    // Subscription Payment Approval
    Route::post('/subscriptions/{subscription}/approve', [App\Http\Controllers\SubscriptionPaymentController::class, 'approvePayment'])->name('subscriptions.approve');
    Route::post('/subscriptions/{subscription}/reject', [App\Http\Controllers\SubscriptionPaymentController::class, 'rejectPayment'])->name('subscriptions.reject');
    
    // Program Management
    Route::resource('programs', App\Http\Controllers\Admin\ProgramController::class);
    Route::post('/programs/{program}/toggle', [App\Http\Controllers\Admin\ProgramController::class, 'toggleStatus'])->name('programs.toggle');
});
