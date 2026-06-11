<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\CallController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OnboardingController;
use App\Http\Controllers\Api\PublicProfileController;
use App\Http\Controllers\Api\StripeCheckoutController as ApiStripeCheckoutController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Onboarding
    Route::post('/onboarding/schedule', [OnboardingController::class, 'saveSchedule']);

    // Tasks
    Route::get('/tasks/history', [TaskController::class, 'history']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{task}', [TaskController::class, 'show']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
    Route::post('/tasks/{task}/complete', [TaskController::class, 'complete']);

    // Calls
    Route::get('/calls', [CallController::class, 'index']);
    Route::get('/calls/{call}', [CallController::class, 'show']);
    Route::post('/calls/request', [CallController::class, 'requestCall']);
    Route::post('/calls/{call}/cancel', [CallController::class, 'cancelCall']);
    Route::post('/calls/fcm', [CallController::class, 'registerFcm']);

    // Reports
    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/reports/{report}', [ReportController::class, 'show']);
    Route::get('/reports/{report}/pdf', [ReportController::class, 'pdf']);
    Route::post('/reports/daily', [ReportController::class, 'generateDaily']);
    Route::get('/daily-reports', [ReportController::class, 'indexDaily']);
    Route::get('/daily-reports/{dailyReport}', [ReportController::class, 'showDaily']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile', [ProfileController::class, 'update']);

    // Settings
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::post('/settings', [SettingsController::class, 'update']);

    // Community
    Route::get('/community', [CommunityController::class, 'feed']);
    Route::post('/community/posts', [CommunityController::class, 'storePost']);
    Route::put('/community/{post}', [CommunityController::class, 'updatePost']);
    Route::post('/community/{post}/delete', [CommunityController::class, 'destroyPost']);
    Route::post('/community/{post}/like', [CommunityController::class, 'likePost']);
    Route::post('/community/{post}/comment', [CommunityController::class, 'comment']);
    Route::post('/community/follow/{user}', [CommunityController::class, 'follow']);

    // Public Profiles
    Route::get('/profiles/{user}', [PublicProfileController::class, 'show']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);

    // Followers
    Route::get('/followers', [FollowController::class, 'followers']);
    Route::post('/followers/{user}/remove', [FollowController::class, 'removeFollower']);
    Route::post('/followers/{follow}/accept', [FollowController::class, 'acceptFollow']);
    Route::post('/followers/{follow}/reject', [FollowController::class, 'rejectFollow']);

    // Share Report
    Route::post('/reports/{dailyReport}/share', [\App\Http\Controllers\Api\ReportController::class, 'shareReport']);

    // Stripe Checkout
    Route::post('/stripe/checkout', [ApiStripeCheckoutController::class, 'createCheckoutSession']);
});
