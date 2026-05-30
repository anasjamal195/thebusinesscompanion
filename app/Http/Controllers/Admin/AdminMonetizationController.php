<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonetizationSetting;
use Illuminate\Http\Request;

class AdminMonetizationController extends Controller
{
    public function index()
    {
        $settings = MonetizationSetting::getInstance();
        return view('admin.monetization.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'per_minute_rate' => 'required|numeric|min:0.01',
            'minimum_refill' => 'required|numeric|min:0.01',
        ]);

        $settings = MonetizationSetting::getInstance();
        $settings->update($data);

        return redirect()->route('admin.monetization.index')->with('success', 'Monetization settings updated.');
    }
}
