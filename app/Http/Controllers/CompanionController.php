<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AiCharacter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CompanionController extends Controller
{
    public function index()
    {
        $companions = AiCharacter::all();
        return view('companions.index', compact('companions'));
    }

    public function show($id)
    {
        $aiCharacter = AiCharacter::findOrFail($id);
        return view('companions.show', compact('aiCharacter'));
    }

    public function checkoutForm($id)
    {
        $aiCharacter = AiCharacter::findOrFail($id);
        return view('companions.checkout', compact('aiCharacter'));
    }

    public function processCheckout(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        \App\Models\WaitlistEntry::updateOrCreate(
            ['email' => $request->email],
            ['password' => \Illuminate\Support\Facades\Hash::make($request->password)]
        );

        return view('companions.thanks');
    }
}
