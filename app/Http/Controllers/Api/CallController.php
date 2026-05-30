<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\MonetizationSetting;
use App\Services\VapiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        if ($user->calling_preference === 'app') {
            return $this->createAppCall($user, $vapi, $callType, $tasks);
        }

        $result = $vapi->createCall($user, $callType, $tasks);

        if ($result) {
            return response()->json(['message' => 'Call requested successfully!']);
        }

        return response()->json([
            'message' => 'Failed to initiate call. Please try again.',
        ], 500);
    }

    protected function createAppCall($user, VapiService $vapi, string $callType, $tasks)
    {
        $assistant = $vapi->getWebCallAssistant($user, $callType, $tasks);

        $call = Call::create([
            'user_id'   => $user->id,
            'status'    => 'initiating',
            'direction' => 'outbound',
            'metadata'  => [
                'call_type'  => $callType,
                'task_ids'   => $tasks?->pluck('id')->toArray() ?? [],
                'channel'    => 'app',
            ],
        ]);

        try {
            Log::info("VapiService: Initiating app {$callType} call for User {$user->id}");

            return response()->json([
                'message'         => 'Call initiated. Connecting via app...',
                'call_id'         => $call->id,
                'call'            => $call->fresh(),
                'assistant'       => $assistant,
                'vapi_public_key' => config('services.vapi.public_key'),
            ]);

        } catch (\Exception $e) {
            if (isset($call)) {
                $call->update(['status' => 'failed']);
            }
            Log::error("VapiService: Exception — " . $e->getMessage());
            return response()->json(['message' => 'Failed to initiate call.'], 500);
        }
    }

    public function registerFcm(Request $request)
    {
        $request->validate([
            'fcm_token' => ['required', 'string'],
        ]);

        $user = $request->user();
        $user->update(['fcm_token' => $request->fcm_token]);

        return response()->json(['message' => 'FCM token registered.']);
    }
}
