<?php

namespace StuRaBtu\Oidc;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use StuRaBtu\Oidc\Http\Responses\LogoutResponse;

class OidcServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/oidc.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'oidc');
        $this->loadTranslationsFrom(__DIR__.'/../lang/oidc.php', 'oidc');

        /** Register OIDC Socialite Provider */
        Event::listen(function (SocialiteWasCalled $socialite) {
            $socialite->extendSocialite('oidc', \SocialiteProviders\OIDC\Provider::class);
        });

        if (interface_exists(LogoutResponseContract::class)) {
            $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
        }
    }
}
