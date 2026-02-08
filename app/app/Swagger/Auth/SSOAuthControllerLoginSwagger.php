<?php

declare(strict_types=1);

namespace App\Swagger\Auth;

/**
 * @OA\PathItem(
 *     path="/api/v1/auth/sso",
 *
 *     @OA\Post(
 *         path="/api/v1/auth/sso",
 *         tags={"Auth"},
 *         summary="Login with SSO (Google or Facebook)",
 *         description="Authenticate user using Google ID token or Facebook access token and issue JWT",
 *
 *         @OA\RequestBody(
 *             required=true,
 *             @OA\JsonContent(
 *                 required={"token", "provider"},
 *                 @OA\Property(
 *                     property="token",
 *                     type="string",
 *                     example="GOOGLE_ID_TOKEN|FACEBOOK_ACCESS_TOKEN"
 *                 ),
 *                 @OA\Property(
 *                     property="provider",
 *                     type="string",
 *                     example="google|facebook"
 *                 )
 *             )
 *         ),
 *
 *         @OA\Response(
 *             response=200,
 *             description="Successful authentication",
 *             @OA\JsonContent(
 *                 @OA\Property(property="access_token", type="string"),
 *                 @OA\Property(property="token_type", type="string", example="bearer"),
 *                 @OA\Property(property="expires_in", type="integer")
 *                 @OA\Property(property="user", type="object")
 *             )
 *         )
 *     )
 * )
 */

class SSOAuthControllerLoginSwagger {}

