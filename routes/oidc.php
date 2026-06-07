<?php

use Illuminate\Support\Facades\Route;
use StuRaBtu\Oidc\Http\Controllers\OidcController;

Route::middleware('web')->group(function () {

    Route::middleware(['guest', 'throttle:auth'])->group(function () {

        Route::name('auth.oidc.redirect')->get(
            '/auth/oidc/redirect',
            [OidcController::class, 'redirect']
        );

        Route::name('auth.oidc.callback')->get(
            '/auth/oidc/callback',
            [OidcController::class, 'callback']
        );

    });

    Route::name('login')->middleware('guest')->get(
        '/login',
        [OidcController::class, 'login'],
    );
});
