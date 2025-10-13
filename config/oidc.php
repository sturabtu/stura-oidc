<?php

return [
    /*
    The base URL must be set to the URL of your OIDC endpoint excluding the .well-known/openid-configuration part. For example: If https://auth.company.com/application/linkace/.well-known/openid-configuration is your OIDC configuration URL, then https://auth.company.com/application/linkace must be your base URL.
    */
    'base_url' => env('OIDC_BASE_URL'),
    'client_id' => env('OIDC_CLIENT_ID'),
    'client_secret' => env('OIDC_CLIENT_SECRET'),
    'redirect' => env('APP_URL').'/auth/oidc/callback',

    // Optional: Enable JWT signature verification (default: false)
    'verify_jwt' => env('OIDC_VERIFY_JWT', false),

    // Optional: Provide a specific public key for JWT verification
    // If not provided, the key will be fetched from the OIDC provider's JWKS endpoint
    'jwt_public_key' => env('OIDC_JWT_PUBLIC_KEY'),

    // 'scopes' => 'groups roles',
];
