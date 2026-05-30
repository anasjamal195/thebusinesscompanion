<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Call;
use App\Models\WaitlistEntry;
use App\Models\CreditPurchase;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_calls' => Call::count(),
            'total_waitlist' => WaitlistEntry::count(),
            'total_revenue' => CreditPurchase::where('status', 'completed')->sum('amount'),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_purchases' => CreditPurchase::where('status', 'completed')->with('user')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $stats);
    }
}
