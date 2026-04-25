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
        $aiCharacter = AiCharacter::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'character_type' => $aiCharacter->key ?? $aiCharacter->id,
        ]);

        Auth::login($user);

        // If Cashier is set up and we have a valid stripe_price_id
        $stripePriceId = $aiCharacter->stripe_price_id ?: config('services.stripe.default_price_id', 'price_fake123');

        // Proceed to Stripe Checkout Session
        return $user->newSubscription('default', $stripePriceId)
                    ->checkout([
                        'success_url' => route('onboarding.business'),
                        'cancel_url' => route('companions.checkoutForm', $id),
                    ]);
    }
}
