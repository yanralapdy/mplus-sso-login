<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ValidateAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->role !== UserRoleEnum::ADMIN) {
            return response()->json([
                'message' => 'Forbidden. Admin access only.'
            ], 403);
        }

        return $next($request);
    }
}

