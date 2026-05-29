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

        $today = now()->setTimezone($request->user()->timezone)->toDateString();

        $tasks = Task::query()
            ->where('user_id', $request->user()->id)
            ->whereDate('date', $today)
            ->orderByRaw("FIELD(status, 'pending', 'completed', 'discarded')")
            ->latest('id')
            ->get();

        $pendingCount = $tasks->where('status', 'pending')->count();
        $completedCount = $tasks->where('status', 'completed')->count();
        $discardedCount = $tasks->where('status', 'discarded')->count();

        return view('dashboard', [
            'tasks' => $tasks,
            'pendingCount' => $pendingCount,
            'completedCount' => $completedCount,
            'discardedCount' => $discardedCount,
            'totalCount' => $tasks->count(),
            'title' => 'Dashboard',
            'pageTitle' => 'Today\'s Tasks',
            'activeNav' => 'dashboard',
        ]);
    }
}
