<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PaymentTransactionController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\TrainingProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProgressController;
use App\Http\Controllers\UserSubscriptionController;





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
    
Route::get('/payment/{subscription_id}', [PaymentTransactionController::class, 'show'])->name('payment.payment');
Route::post('/payment/{subscription_id}', [PaymentTransactionController::class, 'process'])->name('payment.process');
Route::get('/payment-history', [PaymentTransactionController::class, 'index'])->name('payment.history');

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

Route::get('/exercises', [ExerciseController::class, 'index'])
    ->middleware('auth')
    ->name('exercises');

Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])
    ->middleware('auth')
    ->name('exercises.show');
