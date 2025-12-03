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
        // Landing page
        Route::get('/', fn() => redirect()->route('index'));
        Route::get('/index', [IndexController::class, 'index'])->name('index');

        // Register
        Route::get('/register', [UserController::class, 'showRegister'])->name('register');
        Route::post('/register', [UserController::class, 'register'])->name('register.submit');

        // Login
        Route::get('/login', [UserController::class, 'showLogin'])->name('login');
        Route::post('/login', [UserController::class, 'login'])->name('login.submit');

        // Password Reset
        Route::get('forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

        Route::get('reset-password/{token}/{email}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
        Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Authenticated User Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('user_dashboard');

        // Profile
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::put('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Workout Logs
        Route::resource('workout-logs', WorkoutLogController::class);

        // Subscription Payment
        Route::get('/subscription/payment/{plan}', [SubscriptionPaymentController::class, 'showPaymentForm'])->name('subscription.payment.form');
        Route::post('/subscription/payment/{plan}', [SubscriptionPaymentController::class, 'submitPayment'])->name('subscription.payment.submit');

        // Instructor Requests
        Route::prefix('instructor-requests')->name('customer.')->group(function () {
            Route::get('/', [InstructorRequestController::class, 'index'])->name('instructor-requests');
            Route::get('/{instructorRequest}', [InstructorRequestController::class, 'show'])->name('instructor-request-details');
            Route::post('/{instructorRequest}/cancel', [InstructorRequestController::class, 'cancel'])->name('instructor-requests.cancel');
        });
        Route::post('/instructor/requests/store', [InstructorRequestController::class, 'store'])->name('instructor.requests.store');

        // Logout & Payment Cancel
        Route::get('/logout', [UserController::class, 'logout'])->name('logout.get');
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::get('/payment/cancel', [UserSubscriptionController::class, 'cancel'])->name('payment.cancel');
        Route::post('/payment/cancel', [UserSubscriptionController::class, 'cancel'])->name('payment.cancel.post');

        // Programs & Exercises
        Route::get('/programs', [TrainingProgramController::class, 'index'])->name('programs.index');
        Route::get('/programs/{level}', [TrainingProgramController::class, 'show'])->name('programs.show');

        Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
        Route::get('/index/exercises', [ExerciseController::class, 'index'])->name('index.exercises');
        Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])->name('exercises.show');

        Route::view('/index/pending', 'index.pending_dashboard')->name('pending_dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // User Management
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
        Route::get('/users/{user}/edit', [AdminDashboardController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('users.update');
        Route::post('/users/{user}/subscription', [AdminDashboardController::class, 'updateSubscription'])->name('users.update-subscription');
        Route::post('/users/{user}/subscription/{subscription}/cancel', [AdminDashboardController::class, 'cancelSubscription'])->name('users.cancel-subscription');
        Route::post('/users/{user}/toggle-status', [AdminDashboardController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('users.delete');

        // Programs
        Route::resource('programs', ProgramController::class);
        Route::post('/programs/{program}/toggle', [ProgramController::class, 'toggleStatus'])->name('programs.toggle');
        Route::post('/programs/{program}/enroll', [ProgramController::class, 'enroll'])->name('programs.enroll');

        // Exercises
        Route::resource('exercises', AdminExerciseController::class);
        Route::post('/exercises/{exercise}/toggle', [AdminExerciseController::class, 'toggleStatus'])->name('exercises.toggle');
        Route::get('/create_exercises', [AdminExerciseController::class, 'create'])->name('programs.create_exercise');

        // Subscription Payments
        Route::post('/subscriptions/{subscription}/approve', [SubscriptionPaymentController::class, 'approvePayment'])->name('subscriptions.approve');
        Route::post('/subscriptions/{subscription}/reject', [SubscriptionPaymentController::class, 'rejectPayment'])->name('subscriptions.reject');

        // Reports
        Route::prefix('reports')->group(function () {
            Route::get('/active-members', [ReportController::class, 'activeMembers'])->name('reports.active_members');
            Route::get('/expiring-soon', [ReportController::class, 'expiringSoon'])->name('reports.expiring_soon');
            Route::get('/payments', [ReportController::class, 'payments'])->name('reports.payments');
            Route::get('/pending-payments', [ReportController::class, 'pendingPayments'])->name('reports.pending_payments');
            Route::get('/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
            Route::get('/subscription-status', [ReportController::class, 'subscriptionStatus'])->name('reports.subscription_status');
            Route::get('/full', [ReportController::class, 'full'])->name('reports.full_report');

            // PDF
            Route::get('/active_members_pdf', [ReportController::class, 'activeMembersPDF'])->name('reports.active_members_pdf');
            Route::get('/expiring_soon_pdf', [ReportController::class, 'expiringSoonPDF'])->name('reports.expiring_soon_pdf');
            Route::get('/payments_pdf', [ReportController::class, 'paymentsPDF'])->name('reports.payments_pdf');
            Route::get('/pending_payments_pdf', [ReportController::class, 'pendingPaymentsPDF'])->name('reports.pending_payments_pdf');
            Route::get('/full_report_pdf', [ReportController::class, 'fullReportPDF'])->name('reports.full_report_pdf');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Instructor Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'instructor'])->prefix('instructor')->name('instructor.')->group(function () {
        Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/requests', [InstructorDashboardController::class, 'getRequests'])->name('requests');
        Route::get('/requests/{instructorRequest}', [InstructorDashboardController::class, 'showRequest'])->name('requests.show');
        Route::post('/requests/{instructorRequest}/accept', [InstructorDashboardController::class, 'acceptRequest'])->name('requests.accept');
        Route::post('/requests/{instructorRequest}/decline', [InstructorDashboardController::class, 'declineRequest'])->name('requests.decline');
        Route::post('/requests/{instructorRequest}/complete', [InstructorDashboardController::class, 'completeRequest'])->name('requests.complete');
    });
