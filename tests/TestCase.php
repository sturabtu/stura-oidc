<?php

namespace StuRaBtu\Oidc\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use StuRaBtu\Oidc\OidcServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            OidcServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('oidc.base_url', 'https://auth.example.com/realms/test');
        $app['config']->set('oidc.client_id', 'test-client');
        $app['config']->set('oidc.client_secret', 'secret');
        $app['config']->set('oidc.end_session_endpoint', 'https://auth.example.com/realms/test/protocol/openid-connect/logout');
        $app['config']->set('oidc.logout_redirect', 'https://app.example.com');
        $app['config']->set('oidc.admin_group', 'Admin');
    }
}
