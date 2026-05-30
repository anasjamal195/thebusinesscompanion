<?php

namespace App\Http\Controllers;

use App\Models\MonetizationSetting;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $monetization = MonetizationSetting::getInstance();
        $purchases = $user->creditPurchases()
            ->where('status', 'completed')
            ->latest()
            ->take(10)
            ->get();

        return view('profile.index', compact('user', 'profile', 'monetization', 'purchases'));
    }
}
