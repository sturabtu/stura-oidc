<?php

namespace StuRaBtu\Oidc\Driver;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\OIDC\Provider as OidcProvider;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class Oidc
{
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
     * Obtain the user information from OIDC and transform it into an Application User
     */
    public static function user(): User
    {
        $attributes = static::attributes()->all();

        $user = User::where('btu_id', $attributes['btu_id'])->first() ?? new User;

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
            static::driver()->user()->getRaw(),
        );
    }

    /**
     * Load the default OIDC configuration.
     */
    public static function config(): array
    {
        return require __DIR__.'/../../config/oidc.php';
    }
}
