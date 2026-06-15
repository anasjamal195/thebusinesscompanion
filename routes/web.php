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
// use App\Http\Controllers\AchievementController;
// use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\CommunityController;
// use App\Http\Controllers\HallOfFameController;
// use App\Http\Controllers\MentorController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\CalendarController;

// ── Public ────────────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
});

Route::get('/task-planner', function () {
    return view('task-planner');
})->name('task.planner');

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
    Route::get('/tasks',                   [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks',                  [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}',            [TaskController::class, 'update'])->name('tasks.update');
    Route::post('/tasks/{task}/complete',  [TaskController::class, 'complete'])->name('tasks.complete');
    Route::post('/tasks/mark-day-completed', [TaskController::class, 'markDayCompleted'])->name('tasks.mark-day-completed');
    Route::delete('/tasks/{task}',         [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Calls
    Route::get('/calls',                    [CallController::class, 'index'])->name('calls.index');
    Route::get('/calls/{call}',             [CallController::class, 'show'])->name('calls.show');
    Route::get('/calls/{call}/transcript',  [CallController::class, 'downloadTranscript'])->name('calls.transcript');
    Route::post('/calls/request',           [CallController::class, 'requestCall'])->name('calls.request');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Reports
    Route::get('/reports',               [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}',      [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{report}/pdf',  [ReportController::class, 'pdf'])->name('reports.pdf');
    Route::post('/reports/daily',        [ReportController::class, 'generateDaily'])->name('reports.daily.generate');

    // Daily Reports
    Route::get('/daily-reports/{dailyReport}', [ReportController::class, 'showDaily'])->name('daily-reports.show');

    // Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/data', [CalendarController::class, 'data'])->name('calendar.data');

    // Shared Report to Post
    Route::post('/reports/{dailyReport}/share', [ReportController::class, 'shareReport'])->name('reports.share');

    // Community (Feed only)
    Route::get('/community', [CommunityController::class, 'feed'])->name('community.feed');
    Route::post('/community/posts', [CommunityController::class, 'storePost'])->name('community.posts.store');
    Route::put('/community/{post}', [CommunityController::class, 'updatePost'])->name('community.posts.update');
    Route::post('/community/{post}/delete', [CommunityController::class, 'destroyPost'])->name('community.posts.destroy');
    Route::post('/community/{post}/like', [CommunityController::class, 'like'])->name('community.like');
    Route::post('/community/{post}/comment', [CommunityController::class, 'comment'])->name('community.comment');
    Route::post('/community/follow/{user}', [CommunityController::class, 'follow'])->name('community.follow');

    // Public Profiles
    Route::get('/profiles/{user}', [PublicProfileController::class, 'show'])->name('profiles.public');

    // Followers
    Route::get('/followers', [\App\Http\Controllers\FollowController::class, 'followers'])->name('followers.index');
    Route::post('/followers/{user}/remove', [\App\Http\Controllers\FollowController::class, 'removeFollower'])->name('followers.remove');
    Route::post('/followers/{follow}/accept', [\App\Http\Controllers\FollowController::class, 'acceptFollow'])->name('followers.accept');
    Route::post('/followers/{follow}/reject', [\App\Http\Controllers\FollowController::class, 'rejectFollow'])->name('followers.reject');
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
