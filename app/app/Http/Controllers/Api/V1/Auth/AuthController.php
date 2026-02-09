<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Requests\Api\V1\Auth\AuthLoginFormRequest;
use App\Http\Requests\Api\V1\Auth\AuthRegisterFormRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

final class AuthController
{
    public function login(AuthLoginFormRequest $request)
    {
        $cred = $request->validated();

        $user = User::where('email', $cred['email'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'Invalid user email or password'
            ], 401);
        }

        if ($user->provider && !$user->password) {
            return response()->json([
                'message' => 'This account uses social login. Please sigh in with ' . $user->provider
            ], 403);
        }

        $token = Auth::guard('api')->attempt($cred);

        if (!$token) {
            return response()->json([
                'message' => 'Invalid user email or password'
            ], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => new UserResource(Auth::guard('api')->user())
        ]);

    }

    public function register(AuthRegisterFormRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => new UserResource($user),
        ], 201);
    }

    public function refresh()
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Cannot refresh token. Token is invalid or expired'
            ], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ]);
    }
}
