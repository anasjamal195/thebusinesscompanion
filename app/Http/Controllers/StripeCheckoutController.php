<?php

namespace App\Http\Controllers;

use App\Models\CreditPurchase;
use App\Models\MonetizationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeCheckoutController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:5',
        ]);

        $user = Auth::user();
        $amount = (float) $request->amount;

        $monetization = MonetizationSetting::getInstance();
        $minimum = (float) $monetization->minimum_refill;

        if ($amount < $minimum) {
            return back()->withErrors(['amount' => "Minimum refill is \${$minimum}."]);
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

            return redirect($session->url);
        } catch (\Exception $e) {
            Log::error("StripeCheckout: Failed to create session for User {$user->id}", [
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors(['error' => 'Could not initiate payment. Please try again.']);
        }
    }

    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $endpointSecret = config('services.stripe.webhook_secret');

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe webhook: Invalid payload');
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe webhook: Invalid signature', [
                'signature_prefix' => substr((string) $sigHeader, 0, 20),
                'endpoint_secret_prefix' => substr((string) $endpointSecret, 0, 12) . '...',
                'payload_bytes' => strlen($payload),
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $userId = $session->metadata->user_id ?? null;
            $amount = $session->metadata->amount ?? null;

            if ($userId && $amount) {
                $user = \App\Models\User::find($userId);
                if ($user) {
                    $user->addCredits((float) $amount);

                    CreditPurchase::where('stripe_session_id', $session->id)
                        ->where('status', 'pending')
                        ->update(['status' => 'completed']);

                    Log::info("Stripe webhook: Credited \${$amount} to User {$userId}");
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
