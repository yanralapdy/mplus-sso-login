<?php

declare(strict_types=1);

namespace App\Swagger\Auth;

use OpenApi\Attributes as OA;

class AuthControllerSwagger
{
    #[OA\Post(
        path: '/v1/auth/login',
        summary: 'Login with email and password',
        tags: ['Auth']
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['email', 'password'],
            properties: [
                new OA\Property(property: 'email', type: 'string', example: 'thanurking@mplus.com'),
                new OA\Property(property: 'password', type: 'string', example: 'secret123')
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Login successful',
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'access_token', type: 'string'),
            new OA\Property(property: 'token_type', type: 'string', example: 'bearer'),
            new OA\Property(property: 'expires_in', type: 'integer'),
            new OA\Property(property: 'user', type: 'object')
        ])
    )]
    #[OA\Response(
        response: 401,
        description: 'Invalid credentials'
    )]
    #[OA\Response(
        response: 403,
        description: "Account uses social login"
    )]
    public function login() {}


    #[OA\Post(
        path: '/v1/auth/register',
        summary: 'Register a new user',
        tags: ['Auth']
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['name', 'email', 'password', 'password_confirmation'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'John Doel'),
                new OA\Property(property: 'email', type: 'string', example: 'john@mplus.com'),
                new OA\Property(property: 'password', type: 'string', example: 'secret123'),
                new OA\Property(
                    property: 'password_confirmation',
                    type: 'string',
                    example: 'secret123'
                )
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'access_token', type: 'string'),
            new OA\Property(property: 'token_type', type: 'string', example: 'bearer'),
            new OA\Property(property: 'expires_in', type: 'integer'),
            new OA\Property(property: 'user', type: 'object')
        ]),
        description: 'User registered'
    )]
    public function register() {}

    #[OA\Post(
        path: '/v1/auth/refresh-token',
        summary: 'Refresh JWT token',
        security: [['bearerAuth' => []]],
        tags: ['Auth']
    )]
    #[OA\Response(
        response: 200,
        description: 'Token refreshed successfully',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'access_token', type: 'string'),
                new OA\Property(property: 'token_type', type: 'string', example: 'bearer'),
                new OA\Property(property: 'expires_in', type: 'integer')
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: 'Token invalid or expired'
    )]
    public function refresh() {}
}
