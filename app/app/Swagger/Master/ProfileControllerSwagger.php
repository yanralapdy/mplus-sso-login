<?php

declare(strict_types=1);

namespace App\Swagger\Master;

use OpenApi\Attributes as OA;

final class ProfileControllerSwagger
{
    #[OA\Get(
        path: '/v1/users/profile',
        summary: 'Get authenticated user profile',
        security: [['bearerAuth' => []]],
        tags: ['User']
    )]
    #[OA\Response(
        response: 200,
        description: 'User profile',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 1),
                new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                new OA\Property(property: 'email', type: 'string', example: 'john@example.com')
            ]
        )
    )]
    public function show() {}


    #[OA\Put(
        path: '/v1/users/profile',
        summary: 'Update authenticated user profile',
        security: [['bearerAuth' => []]],
        tags: ['User']
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'john@example.com')
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Profile updated',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Profile updated successfully'),
                new OA\Property(property: 'user', type: 'object')
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: 'Unauthenticated'
    )]
    #[OA\Response(
        response: 422,
        description: 'Validation error'
    )]
    public function update() { }
}
