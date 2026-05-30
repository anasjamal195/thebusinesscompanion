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
        $calls = auth()->user()->calls()
            ->latest()
            ->paginate(10);

        return view('calls.index', [
            'calls' => $calls,
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

            $sent = $fcm->sendIncomingCall(
                $user->id,
                (string) time(),
                $voiceName,
                $callTypeLabel
            );

            if ($sent) {
                return back()->with('success', 'Call initiated! Answer on your mobile app.');
            }

            return back()->withErrors(['error' => 'Failed to notify your mobile app. Make sure you\'re logged in and have notifications enabled.']);
        }

        $result = $vapi->createCall($user, $callType, $tasks);

        if ($result) {
            return back()->with('success', 'Call requested successfully! Check your phone.');
        }

        return back()->withErrors(['error' => 'Failed to initiate call. Please try again.']);
    }
}
