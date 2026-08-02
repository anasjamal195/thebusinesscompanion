<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'service' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        Inquiry::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Thank you for your inquiry! We will get back to you soon.']);
        }

        return redirect()->back()->with('success', 'Thank you for your inquiry! We will get back to you soon.');
    }
}
