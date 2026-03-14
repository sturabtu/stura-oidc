<?php

describe('OidcServiceProvider', function () {

    it('merges the package config automatically', function () {
        // These are the keys that must exist even if the application has not
        // published the config file.
        expect(config('oidc.verify_jwt'))->toBeBool()
            ->and(config('oidc.verify_jwt'))->toBeTrue()
            ->and(config('oidc.admin_group'))->toBe('Admin');
    });

    it('registers routes', function () {
        expect(route('auth.oidc.redirect'))->toEndWith('/auth/oidc/redirect')
            ->and(route('auth.oidc.callback'))->toEndWith('/auth/oidc/callback');
    });
});
