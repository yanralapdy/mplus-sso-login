<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\SSOLoginProviderEnum;
use App\Http\Requests\Api\V1\Auth\SSOAuthFormRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

final class SSOAuthController
{
    public function login(SSOAuthFormRequest $request)
    {
        $data = $request->validated();

        try {
            $provider_data = Socialite::driver($data['provider'])
                ->stateless()
                ->userFromToken($data['token']);

            if (!$provider_data || !$provider_data->getEmail()) {
                throw new \Exception('Invalid user data received from provider.');
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized: Invalid or expired SSO token.',
                'error' => $e->getMessage()
            ], 401);
        }

        return $this->handle_sso_data(provider: SSOLoginProviderEnum::from($data['provider']), provider_data: $provider_data);
    }

    private function handle_sso_data(SSOLoginProviderEnum $provider, $provider_data)
    {
        $user = User::firstOrCreate(
            [
                'email' => $provider_data->getEmail(),
            ],
            [
                'name' => $provider_data->getName() ?? $provider_data->getNickname(),
                'provider' => $provider,
                'provider_id' => $provider_data->getId(),
            ]
        );

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => new UserResource($user),
        ]);
    }
}
