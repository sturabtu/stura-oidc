<?php

namespace StuRaBtu\Oidc;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use StuRaBtu\Oidc\Http\Responses\LogoutResponse;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

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

        /** Register rate limiter for Auth Routes */
        RateLimiter::for('auth', function (Request $request) {
            return [
                Limit::perHour(20)->by('hour:'.$request->ip()),
                Limit::perMinute(10)->by('minute:'.$request->ip()),
                Limit::perSecond(4)->by('second:'.$request->ip()),
            ];
        });
    }
}
