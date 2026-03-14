<?php

namespace StuRaBtu\Oidc\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class LogoutResponse implements LogoutResponseContract
{
    /**
     * Redirect Filament logout through OIDC Single Logout.
     *
     * Filament already invalidates the local session before this response is
     * built, so we only need to forward the user to Keycloak's
     * end_session_endpoint (if configured) to propagate the logout to the
     * upstream SAML IdP as well.
     */
    public function toResponse($request): RedirectResponse
    {
        // Filament may pass a Request object or an HTTP foundation request;
        // retrieve the id_token from the session before it is regenerated.
        $idToken = $request->session()->pull('oidc_id_token');

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
