<?php

namespace App\Services\SSO;

use Illuminate\Support\Facades\Http;

class SSOFacebookService implements SSOServiceInterface
{
    public function verify(string $token): array
    {
        $appToken = config('services.facebook.client_id') . '|' .
            config('services.facebook.client_secret');

        $debug = Http::get('https://graph.facebook.com/debug_token', [
            'input_token' => $token,
            'access_token' => $appToken,
        ])->json();

        if (!($debug['data']['is_valid'] ?? false)) {
            throw new \Exception('Invalid Facebook token.');
        }

        if ($debug['data']['app_id'] !== config('services.facebook.client_id')) {
            throw new \Exception('Token not issued for this app.');
        }

        $user = Http::get('https://graph.facebook.com/me', [
            'fields' => 'id,name,email',
            'access_token' => $token,
        ])->json();

        if (!isset($user['email'])) {
            throw new \Exception('Facebook email not available.');
        }

        return [
            'provider_id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name'] ?? null,
        ];
    }
}
