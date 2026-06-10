<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tz = $user->timezone;

        $weekStart = request('week_start')
            ? now()->parse(request('week_start'))
            : now()->setTimezone($tz)->startOfWeek();

        $weekEnd = $weekStart->copy()->endOfWeek();

        $tasks = Task::where('user_id', $user->id)
            ->whereBetween('date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->orderBy('date')
            ->orderBy('priority', 'desc')
            ->get()
            ->groupBy(fn ($t) => $t->date);

        return view('calendar.index', compact('tasks', 'weekStart', 'weekEnd'));
    }

    public function data()
    {
        $user = Auth::user();
        $tz = $user->timezone;

        $month = request('month', now()->month);
        $year = request('year', now()->year);

        $start = now()->setTimezone($tz)->setDay(1)->setMonth($month)->setYear($year)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $tasks = Task::where('user_id', $user->id)
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('DATE(date) as task_date, COUNT(*) as total, SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
            ->groupBy('task_date')
            ->get()
            ->keyBy('task_date');

        return response()->json($tasks);
    }
}
