<?php

namespace StuRaBtu\Oidc\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use LightSaml\Error\LightSamlException;
use StuRaBtu\Oidc\Driver\Oidc;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class OidcController
{
    /**
     * Redirect the user to the OIDC authentication page.
     */
    public function redirect(Request $request): RedirectResponse|SymfonyRedirectResponse
    {
        if (! App::isProduction()) {
            $user = User::where('email', 'test@example.com')->first();

            Auth::login($user, remember: false);
            $request->session()->regenerate();

            Cookie::queue('is_authenticated', true, 30 * 24 * 60);

            return Redirect::route('dashboard');
        }

        return Oidc::redirectToIdentityProvider();
    }

    /**
     * Obtain the user information from OIDC and log the user in.
     */
    public function callback(Request $request): RedirectResponse|View
    {
        try {
            $user = Oidc::user();

            Auth::login($user, remember: false);
            $request->session()->regenerate();

            Cookie::queue('is_authenticated', true, 30 * 24 * 60);

            return Redirect::route('dashboard');
        } catch (LightSamlException) {
            return view('oidc::error');
        }
    }
}
