<?php

namespace App\Swagger;

/**
 * @OA\OpenApi(
 *   @OA\Server(
 *      url="/api",
 *      description="MPlus API"
 *   ),
 *
 *   @OA\Info(
 *      title="MPlus API",
 *      version="1.0.0",
 *   ),
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
*/
class OpenApi {}

