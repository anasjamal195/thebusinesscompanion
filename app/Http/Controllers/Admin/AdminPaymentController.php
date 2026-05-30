<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditPurchase;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $purchases = CreditPurchase::with('user')->latest()->paginate(20);
        $total_revenue = CreditPurchase::where('status', 'completed')->sum('amount');
        $total_refunds = CreditPurchase::where('status', 'refunded')->sum('amount');
        $pending_count = CreditPurchase::where('status', 'pending')->count();

        return view('admin.payments.index', compact('purchases', 'total_revenue', 'total_refunds', 'pending_count'));
    }
}
