<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\MonetizationSetting;
use App\Services\FcmNotificationService;
use App\Services\VapiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CallController extends Controller
{
    /**
     * Display a listing of the call logs.
     */
    public function index()
    {
        $rate = (float) MonetizationSetting::getInstance()->per_minute_rate;

        $calls = auth()->user()->calls()
            ->latest()
            ->paginate(10);

        $calls->getCollection()->transform(function ($call) use ($rate) {
            $call->cost = $call->duration ? round(($call->duration / 60) * $rate, 2) : 0;
            return $call;
        });

        $totalCost = $calls->getCollection()->sum('cost');

        return view('calls.index', [
            'calls' => $calls,
            'totalCost' => $totalCost,
            'perMinuteRate' => $rate,
            'activeNav' => 'calls',
            'pageTitle' => 'Call Logs'
        ]);
    }

    /**
     * Display the specified call log.
     */
    public function show(Call $call)
    {
        $this->authorize('view', $call);

        return view('calls.show', [
            'call' => $call,
            'activeNav' => 'calls',
            'pageTitle' => 'Call Details'
        ]);
    }

    /**
     * Request a manual call from the dashboard.
     * Initiates a followup-type call that checks in on recent activity.
     */
    public function requestCall(VapiService $vapi, FcmNotificationService $fcm)
    {
        $user = Auth::user();

        $rate = (float) MonetizationSetting::getInstance()->per_minute_rate;
        if (!$user->hasSufficientCredits($rate)) {
            return back()->withErrors(['credits' => 'Insufficient credits. Please refill to request a call.']);
        }

        $tasks = \App\Models\Task::where('user_id', $user->id)
            ->whereDate('date', now()->setTimezone($user->timezone)->toDateString())
            ->get();

        $callType = $tasks->where('status', 'pending')->isNotEmpty() ? 'followup' : 'morning';

        if ($user->calling_preference === 'app') {
            $voiceId = $user->voice_id ?? VapiService::DEFAULT_VOICE_ID;
            $voiceName = VapiService::VOICES[$voiceId]['name'] ?? 'Jessica';
            $callTypeLabel = $callType === 'morning' ? 'morning check-in' : 'follow-up';

            // Pre-create the call record in initiating state so decline actions don't 404
            $call = Call::create([
                'user_id'   => $user->id,
                'status'    => 'initiating',
                'direction' => 'outbound',
                'metadata'  => [
                    'call_type' => $callType,
                    'task_ids'  => $tasks?->pluck('id')->toArray() ?? [],
                    'channel'   => 'app',
                ],
            ]);

            $sent = $fcm->sendIncomingCall(
                $user->id,
                (string) $call->id,
                $voiceName,
                $callTypeLabel
            );

            if ($sent) {
                return back()->with('success', 'Call initiated! Answer on your mobile app.');
            }

            // Clean up the call record if FCM notification failed to send
            if (isset($call)) {
                $call->delete();
            }

            return back()->withErrors(['error' => 'Failed to notify your mobile app. Make sure you\'re logged in and have notifications enabled.']);
        }

        $result = $vapi->createCall($user, $callType, $tasks);

        if ($result) {
            return back()->with('success', 'Call requested successfully! Check your phone.');
        }

        return back()->withErrors(['error' => 'Failed to initiate call. Please try again.']);
    }

    public function downloadTranscript(Call $call)
    {
        $this->authorize('view', $call);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('calls.pdf', [
            'call' => $call,
        ])->setPaper('a4');

        return $pdf->download('transcript-call-' . $call->id . '.pdf');
    }
}
