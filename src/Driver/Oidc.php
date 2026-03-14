<?php

namespace StuRaBtu\Oidc\Driver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use SocialiteProviders\OIDC\Provider as OidcProvider;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class Oidc
{
    /**
     * Cached socialite user to avoid consuming the one-time OAuth code more than once.
     */
    private static ?SocialiteUser $socialiteUser = null;

    /**
     * Get the OIDC driver.
     */
    public static function driver(): OidcProvider
    {
        return Socialite::driver('oidc');
    }

    /**
     * Redirect the user to the OIDC authentication page.
     */
    public static function redirectToIdentityProvider(): RedirectResponse|SymfonyRedirectResponse
    {
        return static::driver()->redirect();
    }

    /**
     * Fetch (and cache) the socialite user for the current request.
     * The OAuth authorization code is single-use, so we must not call
     * driver()->user() more than once per request.
     */
    public static function socialiteUser(): SocialiteUser
    {
        if (static::$socialiteUser === null) {
            static::$socialiteUser = static::driver()->user();
        }

        return static::$socialiteUser;
    }

    /**
     * The id_token returned by Keycloak, needed for Single Logout.
     */
    public static function idToken(): ?string
    {
        return static::socialiteUser()->accessTokenResponseBody['id_token'] ?? null;
    }

    /**
     * Obtain the user information from OIDC and persist / update the local user record.
     */
    public static function user(): Model
    {
        $attributes = static::attributes()->all();

        /** @var class-string<Model> $model */
        $model = static::userModel();

        /** @var Model $user */
        $user = $model::where('btu_id', $attributes['btu_id'])->first() ?? new $model;

        $user->fill($attributes);
        $user->save();

        return $user;
    }

    /**
     * Get the OIDC attributes.
     */
    public static function attributes(): OidcAttributes
    {
        return new OidcAttributes(
            static::socialiteUser()->getRaw(),
        );
    }

    /**
     * Resolve the user model class to use.
     *
     * Prefers config('oidc.user_model'), then config('auth.providers.users.model'),
     * and finally falls back to App\Models\User.
     *
     * @return class-string<Model>
     */
    public static function userModel(): string
    {
        return config('oidc.user_model')
            ?? config('auth.providers.users.model')
            ?? \App\Models\User::class;
    }

    /**
     * Load the resolved OIDC configuration.
     */
    public static function config(): array
    {
        return config('oidc');
    }
}
