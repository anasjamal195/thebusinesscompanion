<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaitlistEntry;
use Illuminate\Http\Request;

class AdminWaitlistController extends Controller
{
    public function index()
    {
        $entries = WaitlistEntry::latest()->paginate(20);
        return view('admin.waitlist.index', compact('entries'));
    }

    public function destroy(WaitlistEntry $entry)
    {
        $entry->delete();
        return redirect()->route('admin.waitlist.index')->with('success', 'Waitlist entry removed.');
    }
}
