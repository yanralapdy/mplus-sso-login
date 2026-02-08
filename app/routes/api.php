<?php

declare(strict_types=1);

use App\Http\Controllers\SSOAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('sso-auth', [SSOAuthController::class, 'login']);
    });
});
