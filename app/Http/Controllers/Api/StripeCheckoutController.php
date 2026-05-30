<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CreditPurchase;
use App\Models\MonetizationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeCheckoutController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:5',
        ]);

        $user = $request->user();
        $amount = (float) $validated['amount'];

        $monetization = MonetizationSetting::getInstance();
        $minimum = (float) $monetization->minimum_refill;

        if ($amount < $minimum) {
            return response()->json([
                'message' => "Minimum refill is \${$minimum}.",
            ], 422);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::create([
                'mode' => 'payment',
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Credit Refill',
                            'description' => "Add \${$amount} in credits to your account. 1 credit = \$1.",
                        ],
                        'unit_amount' => (int) ($amount * 100),
                    ],
                    'quantity' => 1,
                ]],
                'customer_email' => $user->email,
                'metadata' => [
                    'user_id' => (string) $user->id,
                    'amount' => (string) $amount,
                ],
                'success_url' => route('checkout.thank-you') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.thank-you') . '?cancelled=1',
            ]);

            CreditPurchase::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'credits_added' => $amount,
                'stripe_session_id' => $session->id,
                'status' => 'pending',
            ]);

            return response()->json([
                'checkout_url' => $session->url,
                'session_id' => $session->id,
            ]);
        } catch (\Exception $e) {
            Log::error("StripeCheckout API: Failed to create session for User {$user->id}", [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Could not initiate payment. Please try again.',
            ], 500);
        }
    }
}
