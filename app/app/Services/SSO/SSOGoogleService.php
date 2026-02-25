<?php

namespace App\Services\SSO;

use Google_Client;

class SSOGoogleService implements SSOServiceInterface
{
    public function verify(string $token): array
    {
        $client = new Google_Client([
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
        ]);

        $payload = $client->verifyIdToken($token);

        if (!$payload) {
            throw new \Exception('Invalid Google ID token.');
        }

        if (!($payload['email_verified'] ?? false)) {
            throw new \Exception('Google email not verified.');
        }

        return [
            'provider_id' => $payload['sub'],
            'email' => $payload['email'],
            'name' => $payload['name'] ?? null,
        ];
    }
}
