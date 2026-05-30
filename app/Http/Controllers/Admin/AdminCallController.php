<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Call;

class AdminCallController extends Controller
{
    public function index()
    {
        $calls = Call::with('user')
            ->latest()
            ->paginate(25);

        return view('admin.calls.index', compact('calls'));
    }

    public function show(Call $call)
    {
        $call->load('user');
        return view('admin.calls.show', compact('call'));
    }
}
