<?php

declare(strict_types=1);

namespace App\Swagger\Auth;

use OpenApi\Attributes as OA;

class SSOAuthControllerLoginSwagger
{
    #[OA\Post(
        path: '/v1/auth/sso',
        summary: 'Login with SSO (Google or Facebook)',
        description: 'Authenticate user using Google ID token or Facebook access token and issue JWT',
        tags: ['Auth']
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['token', 'provider'],
            properties: [
                new OA\Property(
                    property: 'token',
                    type: 'string',
                    example: 'GOOGLE_ID_TOKEN|FACEBOOK_ACCESS_TOKEN'
                ),
                new OA\Property(
                    property: 'provider',
                    type: 'string',
                    example: 'google|facebook'
                )
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful authentication',
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'access_token', type: 'string'),
            new OA\Property(property: 'token_type', type: 'string', example: 'bearer'),
            new OA\Property(property: 'expires_in', type: 'integer'),
            new OA\Property(property: 'user', type: 'object')
        ])
    )]
    public function login()
    {        // This method exists only for the scanner to attach attributes
    }
}
