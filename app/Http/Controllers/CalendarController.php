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

        $month = request('month', now()->setTimezone($tz)->month);
        $year = request('year', now()->setTimezone($tz)->year);

        $monthStart = now()->setTimezone($tz)->setDay(1)->setMonth($month)->setYear($year)->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        $tasks = Task::where('user_id', $user->id)
            ->whereBetween('date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->orderBy('date')
            ->orderBy('priority', 'desc')
            ->get()
            ->groupBy(fn ($t) => $t->date);

        $prevMonth = $monthStart->copy()->subMonth()->month;
        $prevYear = $monthStart->copy()->subMonth()->year;
        $nextMonth = $monthStart->copy()->addMonth()->month;
        $nextYear = $monthStart->copy()->addMonth()->year;

        return view('calendar.index', compact('tasks', 'monthStart', 'monthEnd', 'prevMonth', 'nextMonth', 'prevYear', 'nextYear'));
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
