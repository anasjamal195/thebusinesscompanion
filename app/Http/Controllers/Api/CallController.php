<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\MonetizationSetting;
use App\Services\FcmNotificationService;
use App\Services\VapiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
            $payload = [
                'assistant' => $assistant,
                'metadata'  => [
                    'local_call_id' => (string) $call->id,
                ],
            ];

            Log::info("VapiService: Initiating app {$callType} call for User {$user->id}");

            $response = Http::withToken(config('services.vapi.private_key'))
                ->post('https://api.vapi.ai/call', $payload);

            if ($response->successful()) {
                $vapiCall = $response->json();

                $call->update([
                    'call_id' => $vapiCall['id'],
                    'status'  => 'waiting',
                ]);

                $fcm = app(FcmNotificationService::class);
                $fcm->sendIncomingCall($user->id, $vapiCall['id'], 'dialer.best', $callType);

                $clientToken = $this->generateClientToken($vapiCall['id']);

                return response()->json([
                    'message'    => 'Call initiated. Connecting via app...',
                    'call_id'    => $vapiCall['id'],
                    'call'       => $call->fresh(),
                    'assistant'  => $assistant,
                    'token'      => $clientToken,
                ]);
            }

            $call->update(['status' => 'failed']);
            Log::error("VapiService: Vapi API error {$response->status()}", ['body' => $response->body()]);
            return response()->json(['message' => 'Failed to initiate call.'], 500);

        } catch (\Exception $e) {
            if (isset($call)) {
                $call->update(['status' => 'failed']);
            }
            Log::error("VapiService: Exception — " . $e->getMessage());
            return response()->json(['message' => 'Failed to initiate call.'], 500);
        }
    }

    protected function generateClientToken(string $callId): string
    {
        $key = config('services.vapi.private_key');
        $parts = explode('.', $key);
        if (count($parts) === 3) {
            $header = base64_encode('{"alg":"HS256","typ":"JWT"}');
            $payload = base64_encode(json_encode([
                'callId' => $callId,
                'iat'    => time(),
                'exp'    => time() + 3600,
            ]));
            $signature = base64_encode(hash_hmac('sha256', "$header.$payload", $key, true));
            return "$header.$payload.$signature";
        }
        return $callId;
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
