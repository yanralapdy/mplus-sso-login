<?php

namespace App\Http\Controllers\Api\V2\Auth;

use App\Enums\SSOLoginProviderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\SSOAuthFormRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use App\Services\SSO\SSOServiceFactory;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class V2SSOAuthController extends Controller
{
    public function login(SSOAuthFormRequest $request)
    {
        $data = $request->validated();

        try {
            $provider_enum = SSOLoginProviderEnum::from($data['provider']);
            $sso_service = SSOServiceFactory::make($provider_enum);
            $sso_data = $sso_service->verify($data['token']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => $e->getMessage()
            ], 401);
        }

        return $this->handleSSOData($provider_enum, $sso_data);
    }

    private function handleSSOData(SSOLoginProviderEnum $service, array $sso_data)
    {
        $user = User::updateOrCreate(
            ['email' => $sso_data['email']],
            [
                'name' => $sso_data['name'],
                'provider' => $service->value,
                'provider_id' => $sso_data['provider_id'],
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
