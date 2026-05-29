<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CallController;

// ── Public ────────────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
});

Route::post('/waitlist', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'email' => 'required|email|unique:waitlist_entries,email'
    ]);

    \App\Models\WaitlistEntry::create(['email' => $request->email]);

    return response()->json(['message' => 'Success']);
})->name('waitlist.store');

// ── Guest ─────────────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login',   [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('/register',  [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ── Authenticated ─────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    // Onboarding
    Route::get('/onboarding/schedule',  [OnboardingController::class, 'schedule'])->name('onboarding.schedule');
    Route::post('/onboarding/schedule', [OnboardingController::class, 'saveSchedule'])->name('onboarding.schedule.save');

    // Dashboard
    Route::get('/dashboard', [ProjectController::class, 'index'])->name('dashboard');

    // Settings
    Route::get('/settings',  [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Tasks
    Route::post('/tasks',                  [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}',            [TaskController::class, 'update'])->name('tasks.update');
    Route::post('/tasks/{task}/complete',  [TaskController::class, 'complete'])->name('tasks.complete');

    // Calls
    Route::get('/calls',         [CallController::class, 'index'])->name('calls.index');
    Route::get('/calls/{call}',  [CallController::class, 'show'])->name('calls.show');

    // Reports
    Route::get('/reports',               [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}',      [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{report}/pdf',  [ReportController::class, 'pdf'])->name('reports.pdf');
});

// ── Webhooks (unauthenticated, verified by signature) ─────────────────────────

Route::post('/vapi/webhook', [\App\Http\Controllers\VapiWebhookController::class, 'handle'])->name('vapi.webhook');
