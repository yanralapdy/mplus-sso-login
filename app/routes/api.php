<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\SSOAuthController;
use App\Http\Controllers\Api\V1\Master\ProfileController;
use App\Http\Controllers\Api\V1\Master\UserController;
use App\Http\Controllers\Api\V2\Auth\V2SSOAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('sso', [SSOAuthController::class, 'login']);

        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('refresh-token', [AuthController::class, 'refresh']);
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/profile', [ProfileController::class, 'show']);
            Route::put('/profile', [ProfileController::class, 'update']);
        });

        Route::middleware(['admin'])->prefix('admin')->group(function () {
            Route::prefix('users')->group(function () {
                Route::get('/', [UserController::class, 'index']);
            });
        });
    });
});

Route::prefix('v2')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('sso', [V2SSOAuthController::class, 'login']);
    });
});
