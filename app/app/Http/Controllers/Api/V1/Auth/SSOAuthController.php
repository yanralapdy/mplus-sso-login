<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\SSOLoginProviderEnum;
use App\Http\Requests\SSOAuthFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

final class SSOAuthController
{
    public function login(SSOAuthFormRequest $request)
    {
        $data = $request->validated();

        $provider_data = Socialite::driver($data['provider'])
            ->stateless()
            ->userFromToken($request->token);

        return $this->handle_sso_data(provider: $data['provider'], provider_data: $provider_data);
    }

    private function handle_sso_data(SSOLoginProviderEnum $provider, $provider_data)
    {
        $user = User::firstOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $provider_data->getId(),
            ],
            [
                'name' => $provider_data->getName() ?? $provider_data->getNickname(),
                'email' => $provider_data->getEmail(),
                'provider' => $provider,
                'provider_id' => $provider_data->getId(),
            ]
        );

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => $user,
        ]);
    }
}
