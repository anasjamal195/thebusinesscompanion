<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tz = $user->timezone;

        $month = (int) request('month', now()->setTimezone($tz)->month);
        $year = (int) request('year', now()->setTimezone($tz)->year);

        $monthStart = now()->setTimezone($tz)->setDay(1)->setMonth($month)->setYear($year)->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        $tasks = Task::where('user_id', $user->id)
            ->whereBetween('date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->orderBy('date')
            ->orderBy('priority', 'desc')
            ->get()
            ->groupBy(fn ($t) => $t->date);

        $taskCompletedDates = Task::where('user_id', $user->id)
            ->whereBetween('date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->selectRaw('date, SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_count, COUNT(*) as total_count')
            ->groupBy('date')
            ->havingRaw('completed_count = total_count')
            ->pluck('date')
            ->toArray();

        $reportDates = DailyReport::where('user_id', $user->id)
            ->whereBetween('report_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->pluck('report_date')
            ->map(fn ($d) => $d->toDateString())
            ->toArray();

        $completedDates = array_values(array_unique(array_merge($taskCompletedDates, $reportDates)));

        $prevMonth = $monthStart->copy()->subMonth()->month;
        $prevYear = $monthStart->copy()->subMonth()->year;
        $nextMonth = $monthStart->copy()->addMonth()->month;
        $nextYear = $monthStart->copy()->addMonth()->year;

        return view('calendar.index', compact('tasks', 'monthStart', 'monthEnd', 'prevMonth', 'nextMonth', 'prevYear', 'nextYear', 'completedDates'));
    }

    public function data()
    {
        $user = Auth::user();
        $tz = $user->timezone;

        $month = (int) request('month', now()->month);
        $year = (int) request('year', now()->year);

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
