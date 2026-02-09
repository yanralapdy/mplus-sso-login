<?php

declare(strict_types=1);

namespace App\Swagger\Master;

use OpenApi\Attributes as OA;

final class UserControllerIndexSwagger
{
    #[OA\Get(
        path: '/v1/admin/users',
        summary: 'Get all users (admin only)',
        security: [['bearerAuth' => []]],
        tags: ['Admin']
    )]
    #[OA\QueryParameter(
        name: 'type',
        description: 'pagination or all',
        schema: new OA\Schema(type: 'string', example: 'pagination')
    )]
    #[OA\QueryParameter(
        name: 'per_page',
        description: 'Items per page',
        schema: new OA\Schema(type: 'integer', example: 10)
    )]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'access_token', type: 'string'),
            new OA\Property(property: 'token_type', type: 'string', example: 'bearer'),
            new OA\Property(property: 'expires_in', type: 'integer'),
            new OA\Property(property: 'user', type: 'object')
        ])
    )]
    #[OA\Response(
        response: 403,
        description: 'Forbidden'
    )]
    public function index() {}
}
