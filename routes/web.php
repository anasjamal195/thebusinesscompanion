<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\GoogleSocialiteController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\StripeCheckoutController;
use App\Http\Controllers\VoicePreviewController;

// ── Public ────────────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mobile-app', function () {
    return view('mobile-app');
})->name('mobile.app');

Route::get('/download-apk', function () {
    $filePath = storage_path('app/apk/dialer-best.apk');
    if (file_exists($filePath)) {
        return response()->download($filePath, 'dialer-best.apk');
    }
    abort(404, 'APK file not found. It will be available soon.');
})->name('apk.download');

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

    Route::get('/auth/google/redirect', [GoogleSocialiteController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleSocialiteController::class, 'callback'])->name('google.callback');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ── Checkout ─────────────────────────────────────────────────────────────────

Route::get('/checkout/thank-you', function () {
    return view('checkout.thank-you');
})->name('checkout.thank-you');

// ── Authenticated ─────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    // Onboarding
    Route::get('/onboarding/schedule',  [OnboardingController::class, 'schedule'])->name('onboarding.schedule');
    Route::post('/onboarding/schedule', [OnboardingController::class, 'saveSchedule'])->name('onboarding.schedule.save');

    // Dashboard
    Route::get('/dashboard', [ProjectController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    // Stripe Credit Refill Checkout
    Route::post('/stripe/checkout', [StripeCheckoutController::class, 'createCheckoutSession'])->name('stripe.checkout');

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
    Route::post('/calls/request', [CallController::class, 'requestCall'])->name('calls.request');

    // Notifications
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Reports
    Route::get('/reports',               [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}',      [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{report}/pdf',  [ReportController::class, 'pdf'])->name('reports.pdf');
    Route::post('/reports/daily',        [ReportController::class, 'generateDaily'])->name('reports.daily.generate');

    // Daily Reports
    Route::get('/daily-reports/{dailyReport}', [ReportController::class, 'showDaily'])->name('daily-reports.show');
});

// ── Voice Previews ────────────────────────────────────────────────────────────

Route::get('/api/voice-preview/{voiceId}', VoicePreviewController::class)->name('voice.preview');

// ── Admin ──────────────────────────────────────────────────────────────────────

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCallController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminMonetizationController;
use App\Http\Controllers\Admin\AdminWaitlistController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                         [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users',                    [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}',             [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/calls',                    [AdminCallController::class, 'index'])->name('calls.index');
    Route::get('/calls/{call}',             [AdminCallController::class, 'show'])->name('calls.show');
    Route::get('/payments',                 [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/monetization',             [AdminMonetizationController::class, 'index'])->name('monetization.index');
    Route::post('/monetization',            [AdminMonetizationController::class, 'update'])->name('monetization.update');
    Route::get('/waitlist',                 [AdminWaitlistController::class, 'index'])->name('waitlist.index');
    Route::delete('/waitlist/{entry}',      [AdminWaitlistController::class, 'destroy'])->name('waitlist.destroy');
});

// ── Webhooks (unauthenticated, verified by signature) ─────────────────────────

Route::post('/vapi/webhook', [\App\Http\Controllers\VapiWebhookController::class, 'handle'])->name('vapi.webhook');
Route::post('/stripe/webhook', [StripeCheckoutController::class, 'handleWebhook'])->name('stripe.webhook');
