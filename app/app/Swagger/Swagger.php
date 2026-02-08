<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(title: "MPlus Api", version: "1.0.0", description: "API documentation for my Laravel project")]
#[OA\Server(url: "/api", description: "MPlus API Server")]
#[OA\SecurityScheme(type: "http", description: "Login with email and password to get the authentication token", name: "Token Based", in: "header", scheme: "bearer", bearerFormat: "JWT", securityScheme: "bearerAuth")]
final class Swagger {}
