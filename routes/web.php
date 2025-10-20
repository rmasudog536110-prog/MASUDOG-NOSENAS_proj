<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Register
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');

// Login
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


Route::get('/programs', [WebController::class, 'programs'])->name('programs');

Route::get('/exercises', [WebController::class, 'exercises'])->name('exercises');

