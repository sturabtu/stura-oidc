<?php

return [
    /*
    The base URL must be set to the URL of your OIDC endpoint excluding the .well-known/openid-configuration part. For example: If https://auth.company.com/application/linkace/.well-known/openid-configuration is your OIDC configuration URL, then https://auth.company.com/application/linkace must be your base URL.
    */
    'base_url' => env('OIDC_BASE_URL'),
    'client_id' => env('OIDC_CLIENT_ID'),
    'client_secret' => env('OIDC_CLIENT_SECRET'),
    'redirect' => env('APP_URL').'/auth/oidc/callback',

    // Enable JWT signature verification.
    // Strongly recommended in production; tokens come from an external Keycloak instance.
    'verify_jwt' => env('OIDC_VERIFY_JWT', true),

    // Optional: Provide a specific public key for JWT verification.
    // If not provided, the key will be fetched from the OIDC provider's JWKS endpoint.
    'jwt_public_key' => env('OIDC_JWT_PUBLIC_KEY'),

    // Scopes requested from Keycloak. Extend as needed.
    // 'scopes' => 'groups roles',

    /*
    |--------------------------------------------------------------------------
    | Single Logout (SLO)
    |--------------------------------------------------------------------------
    |
    | The end_session_endpoint of your Keycloak realm. Keycloak's default path
    | is: {base_url}/protocol/openid-connect/logout
    |
    | After local logout, the user is redirected here with the id_token_hint
    | and post_logout_redirect_uri so that Keycloak ends the session on the
    | SAML IdP as well.
    |
    */
    'end_session_endpoint' => env('OIDC_END_SESSION_ENDPOINT'),

    // Where to send the user after a successful Keycloak logout.
    'logout_redirect' => env('OIDC_LOGOUT_REDIRECT', env('APP_URL', '/')),

    /*
    |--------------------------------------------------------------------------
    | Authorization
    |--------------------------------------------------------------------------
    */

    // Keycloak group name that grants admin access.
    'admin_group' => env('OIDC_ADMIN_GROUP', 'Admin'),

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | The Eloquent model used to store and retrieve authenticated users.
    | Defaults to the model configured in config/auth.php.
    |
    */
    'user_model' => env('OIDC_USER_MODEL'),
];
