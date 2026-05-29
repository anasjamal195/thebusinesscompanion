<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->morning_call_time) {
            return redirect(\App\Http\Controllers\OnboardingController::getNextOnboardingRoute($request->user()));
        }

        $tasks = Task::query()
            ->where('user_id', $request->user()->id)
            ->whereDate('date', today())
            ->orderBy('status', 'desc') // Pending first, then completed
            ->latest('id')
            ->get();

        return view('dashboard', [
            'tasks' => $tasks,
            'title' => 'Dashboard',
            'pageTitle' => 'Today\'s Tasks',
            'activeNav' => 'dashboard',
        ]);
    }
}
