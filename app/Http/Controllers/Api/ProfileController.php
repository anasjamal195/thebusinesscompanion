<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MonetizationSetting;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('profile');
        $monetization = MonetizationSetting::getInstance();
        $purchases = $user->creditPurchases()
            ->where('status', 'completed')
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'user' => $user,
            'monetization' => $monetization,
            'purchases' => $purchases,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string'],
            'business_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = $request->user();

        if (isset($validated['name'])) {
            $user->update(['name' => $validated['name']]);
        }

        if ($request->has('phone_number') || $request->has('business_name')) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone_number' => $validated['phone_number'] ?? $user->profile?->phone_number,
                    'business_name' => $validated['business_name'] ?? $user->profile?->business_name,
                ]
            );
        }

        return response()->json(['user' => $user->fresh()->load('profile')]);
    }
}
