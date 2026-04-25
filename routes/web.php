<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// UI-only routes (static Blade views).
Route::view('/login', 'auth.login');

Route::view('/onboarding/role', 'onboarding.role');
Route::view('/onboarding/call', 'onboarding.call');
Route::view('/onboarding/business', 'onboarding.business');
Route::view('/onboarding/character', 'onboarding.character');

Route::view('/dashboard', 'dashboard');

Route::get('/projects/{id}', function (string $id) {
    return view('projects.show', ['projectId' => $id]);
});

Route::get('/reports/{id}', function (string $id) {
    return view('reports.show', ['reportId' => $id]);
});
