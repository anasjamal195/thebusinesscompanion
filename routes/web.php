<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChatController;

use App\Http\Controllers\CompanionController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/waitlist', function (Illuminate\Http\Request $request) {
    $request->validate([
        'email' => 'required|email|unique:waitlist_entries,email'
    ]);

    App\Models\WaitlistEntry::create([
        'email' => $request->email
    ]);

    return response()->json(['message' => 'Success']);
})->name('waitlist.store');


Route::get('/companions', [CompanionController::class, 'index'])->name('companions.index');
Route::get('/companions/{id}', [CompanionController::class, 'show'])->name('companions.show');

Route::middleware('guest')->group(function () {
    Route::get('/onboarding/role', [OnboardingController::class, 'role'])->name('onboarding.role');
    Route::post('/onboarding/role', [OnboardingController::class, 'saveRole'])->name('onboarding.role.save');
    
    Route::get('/onboarding/companion', [OnboardingController::class, 'companion'])->name('onboarding.companion');
    Route::post('/onboarding/companion', [OnboardingController::class, 'saveCompanion'])->name('onboarding.companion.save');
    
    Route::get('/onboarding/checkout', [OnboardingController::class, 'checkout'])->name('onboarding.checkout');
    Route::post('/onboarding/checkout', [OnboardingController::class, 'processCheckout'])->name('onboarding.processCheckout');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/onboarding/business', [OnboardingController::class, 'business'])->name('onboarding.business');
    Route::post('/onboarding/business', [OnboardingController::class, 'saveBusiness'])->name('onboarding.business.save');

    Route::get('/onboarding/calling', [OnboardingController::class, 'calling'])->name('onboarding.calling');
    Route::post('/onboarding/calling', [OnboardingController::class, 'saveCalling'])->name('onboarding.calling.save');

    Route::get('/onboarding/method', [OnboardingController::class, 'method'])->name('onboarding.method');
    Route::post('/onboarding/method', [OnboardingController::class, 'saveMethod'])->name('onboarding.method.save');

    Route::get('/onboarding/details', [OnboardingController::class, 'details'])->name('onboarding.details');
    Route::post('/onboarding/details', [OnboardingController::class, 'saveDetails'])->name('onboarding.details.save');

    Route::get('/onboarding/task', [OnboardingController::class, 'task'])->name('onboarding.task');
    Route::post('/onboarding/complete', [OnboardingController::class, 'complete'])->name('onboarding.complete');

    Route::get('/dashboard', [ProjectController::class, 'index'])->name('dashboard');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('/projects/{project}/chat/stream', [ChatController::class, 'stream'])->name('projects.chat.stream');

    Route::get('/projects/{project}/tasks', [TaskController::class, 'getByProject'])->name('projects.tasks');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{report}/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
});
Route::post('/stripe/webhook', [\Laravel\Cashier\Http\Controllers\WebhookController::class, 'handleWebhook']);
