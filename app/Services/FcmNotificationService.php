<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmNotificationService
{
    protected string $credentialsPath;
    protected ?array $credentials = null;
    protected ?string $accessToken = null;
    protected ?int $tokenExpiresAt = null;

    public function __construct(?string $credentialsPath = null)
    {
        $this->credentialsPath = $credentialsPath ?? storage_path('app/firebase-service-account.json');
    }

    public function send(int $userId, string $title, string $body, array $data = []): bool
    {
        $user = \App\Models\User::find($userId);
        if (!$user || !$user->fcm_token) {
            return false;
        }

        $message = [
            'token' => $user->fcm_token,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => array_merge($data, ['click_action' => 'FLUTTER_NOTIFICATION_CLICK']),
            'android' => [
                'priority' => 'high',
                'notification' => [
                    'channel_id' => 'dialer_calls',
                    'sound' => 'default',
                ],
            ],
            'apns' => [
                'headers' => [
                    'apns-priority' => '10',
                ],
                'payload' => [
                    'aps' => [
                        'alert' => [
                            'title' => $title,
                            'body' => $body,
                        ],
                        'sound' => 'default',
                        'badge' => 1,
                    ],
                ],
            ],
        ];

        return $this->sendMessage($message);
    }

    public function sendIncomingCall(int $userId, string $callId, string $callerName = 'dialer.best', string $callType = 'Planning'): bool
    {
        return $this->send(
            $userId,
            'Incoming Call',
            "$callerName is calling you for a $callType session.",
            [
                'type' => 'incoming_call',
                'call_id' => $callId,
                'caller_name' => $callerName,
                'call_type' => $callType,
            ]
        );
    }

    protected function sendMessage(array $message): bool
    {
        $projectId = $this->getProjectId();
        if (!$projectId) {
            return false;
        }

        $token = $this->getAccessToken();
        if (!$token) {
            return false;
        }

        $response = Http::withToken($token)
            ->timeout(15)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                'message' => $message,
            ]);

        if ($response->successful()) {
            Log::info('[FCM] Notification sent', [
                'name' => $response->json('name'),
            ]);
            return true;
        }

        Log::error('[FCM] Failed to send notification', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
        return false;
    }

    protected function getProjectId(): ?string
    {
        $creds = $this->loadCredentials();
        return $creds['project_id'] ?? null;
    }

    protected function loadCredentials(): ?array
    {
        if ($this->credentials !== null) {
            return $this->credentials;
        }

        if (!file_exists($this->credentialsPath)) {
            Log::error('[FCM] Service account file not found: ' . $this->credentialsPath);
            return null;
        }

        $content = file_get_contents($this->credentialsPath);
        $this->credentials = json_decode($content, true);

        if (!$this->credentials || !isset($this->credentials['client_email'])) {
            Log::error('[FCM] Invalid service account JSON');
            $this->credentials = null;
        }

        return $this->credentials;
    }

    protected function getAccessToken(): ?string
    {
        if ($this->accessToken !== null && $this->tokenExpiresAt > time()) {
            return $this->accessToken;
        }

        $creds = $this->loadCredentials();
        if (!$creds) {
            return null;
        }

        $now = time();
        $jwt = $this->createJwt($creds, $now);

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if (!$response->successful()) {
            Log::error('[FCM] Failed to get access token', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }

        $this->accessToken = $response->json('access_token');
        $this->tokenExpiresAt = $now + ($response->json('expires_in', 3600) - 60);

        return $this->accessToken;
    }

    protected function createJwt(array $creds, int $now): string
    {
        $header = $this->base64UrlEncode(json_encode([
            'alg' => 'RS256',
            'typ' => 'JWT',
        ]));

        $payload = $this->base64UrlEncode(json_encode([
            'iss' => $creds['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now,
        ]));

        $signature = '';
        openssl_sign(
            "$header.$payload",
            $signature,
            $creds['private_key'],
            OPENSSL_ALGO_SHA256
        );

        $signature = $this->base64UrlEncode($signature);

        return "$header.$payload.$signature";
    }

    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
