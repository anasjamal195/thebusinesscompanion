<?php

namespace App\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends CashierController
{
    /**
     * Override handleWebhook to log and supplement Cashier logic.
     */
    public function handleWebhook(Request $request)
    {
        Log::info('Stripe Webhook Received: ' . $request->input('type'));
        return parent::handleWebhook($request);
    }

    /**
     * Handle checkout.session.completed.
     */
    protected function handleCheckoutSessionCompleted(array $payload)
    {
        $session = $payload['data']['object'];
        $userId = $session['metadata']['user_id'] ?? null;
        $companionId = $session['metadata']['companion_id'] ?? null;

        if ($userId) {
            $user = User::find($userId);
            if ($user && $companionId) {
                // Perform any custom logic needed for The Business Companion
                $user->update([
                    'companion_id' => $companionId,
                ]);
                Log::info("User {$userId} linked to Companion {$companionId} via Webhook.");
            }
        }

        return parent::handleCheckoutSessionCompleted($payload);
    }
}
