<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\MonetizationSetting;
use App\Services\VapiService;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function index(Request $request)
    {
        $calls = $request->user()->calls()
            ->latest()
            ->get();

        return response()->json(['calls' => $calls]);
    }

    public function show(Request $request, Call $call)
    {
        abort_unless($call->user_id === $request->user()->id, 404);

        return response()->json(['call' => $call]);
    }

    public function requestCall(Request $request, VapiService $vapi)
    {
        $user = $request->user();

        $rate = (float) MonetizationSetting::getInstance()->per_minute_rate;
        if (!$user->hasSufficientCredits($rate)) {
            return response()->json([
                'message' => 'Insufficient credits. Please refill to request a call.',
            ], 402);
        }

        $tasks = \App\Models\Task::where('user_id', $user->id)
            ->whereDate('date', now()->setTimezone($user->timezone ?? 'UTC')->toDateString())
            ->get();

        $callType = $tasks->where('status', 'pending')->isNotEmpty() ? 'followup' : 'morning';

        $result = $vapi->createCall($user, $callType, $tasks);

        if ($result) {
            return response()->json(['message' => 'Call requested successfully!']);
        }

        return response()->json([
            'message' => 'Failed to initiate call. Please try again.',
        ], 500);
    }
}
