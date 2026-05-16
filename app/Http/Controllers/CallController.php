<?php

namespace App\Http\Controllers;

use App\Models\Call;
use Illuminate\Http\Request;

class CallController extends Controller
{
    /**
     * Display a listing of the call logs.
     */
    public function index()
    {
        $calls = auth()->user()->calls()
            ->with('aiCharacter')
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
}
