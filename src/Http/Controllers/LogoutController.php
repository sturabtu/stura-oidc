<?php

namespace StuRaBtu\Oidc\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LogoutController
{
    /**
     * Destroy an authenticated session and initiate OIDC Single Logout.
     *
     * After clearing the local session, the user is redirected to Keycloak's
     * end_session_endpoint so that the upstream SAML IdP session is also
     * terminated. If no endpoint is configured, we fall back to a plain
     * redirect to the configured logout_redirect URL.
     */
    public function logout(Request $request): RedirectResponse
    {
        $idToken = $request->session()->pull('oidc_id_token');

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $endSession = config('oidc.end_session_endpoint');

        if ($endSession) {
            $url = $endSession.'?'.http_build_query(array_filter([
                'id_token_hint' => $idToken,
                'client_id' => config('oidc.client_id'),
                'post_logout_redirect_uri' => config('oidc.logout_redirect', config('app.url', '/')),
            ]));

            return Redirect::away($url)->withoutCookie('is_authenticated');
        }

        return Redirect::to(config('oidc.logout_redirect', '/'))->withoutCookie('is_authenticated');
    }
}
