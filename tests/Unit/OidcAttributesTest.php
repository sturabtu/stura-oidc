<?php

use StuRaBtu\Oidc\Driver\OidcAttributes;

describe('OidcAttributes', function () {

    // ------------------------------------------------------------------ //
    // asString                                                            //
    // ------------------------------------------------------------------ //

    it('returns a string attribute', function () {
        $attrs = new OidcAttributes(['name' => 'Jane Doe']);

        expect($attrs->asString('name'))->toBe('Jane Doe');
    });

    it('returns null for a missing string attribute', function () {
        $attrs = new OidcAttributes([]);

        expect($attrs->asString('name'))->toBeNull();
    });

    // ------------------------------------------------------------------ //
    // asArray                                                             //
    // ------------------------------------------------------------------ //

    it('returns an array attribute', function () {
        $attrs = new OidcAttributes(['roles' => ['editor', 'viewer']]);

        expect($attrs->asArray('roles'))->toBe(['editor', 'viewer']);
    });

    it('returns null for a missing array attribute', function () {
        $attrs = new OidcAttributes([]);

        expect($attrs->asArray('roles'))->toBeNull();
    });

    // ------------------------------------------------------------------ //
    // asDate                                                              //
    // ------------------------------------------------------------------ //

    it('parses a date attribute in Ymd format', function () {
        $attrs = new OidcAttributes(['birthdate' => '19900315']);

        $date = $attrs->asDate('birthdate');

        expect($date)->not->toBeNull()
            ->and($date->year)->toBe(1990)
            ->and($date->month)->toBe(3)
            ->and($date->day)->toBe(15);
    });

    it('returns null for a missing date attribute', function () {
        $attrs = new OidcAttributes([]);

        expect($attrs->asDate('birthdate'))->toBeNull();
    });

    // ------------------------------------------------------------------ //
    // asBtuIdentifier                                                     //
    // ------------------------------------------------------------------ //

    it('strips the BTU suffix from preferred_username', function () {
        $attrs = new OidcAttributes(['preferred_username' => 'jdoe@b-tu.de']);

        expect($attrs->asBtuIdentifier('preferred_username'))->toBe('jdoe');
    });

    it('returns the full value when BTU suffix is absent', function () {
        // Str::before returns the original string if the substring is not found
        $attrs = new OidcAttributes(['preferred_username' => 'jdoe']);

        expect($attrs->asBtuIdentifier('preferred_username'))->toBe('jdoe');
    });

    it('throws when the BTU identifier attribute is missing', function () {
        $attrs = new OidcAttributes([]);

        expect(fn () => $attrs->asBtuIdentifier('preferred_username'))
            ->toThrow(InvalidArgumentException::class);
    });

    // ------------------------------------------------------------------ //
    // asGroups                                                            //
    // ------------------------------------------------------------------ //

    it('returns an empty array when groups attribute is missing', function () {
        $attrs = new OidcAttributes([]);

        expect($attrs->asGroups('groups'))->toBe([]);
    });

    it('returns an empty array for an empty groups list', function () {
        $attrs = new OidcAttributes(['groups' => []]);

        expect($attrs->asGroups('groups'))->toBe([]);
    });

    it('flattens hierarchical Keycloak group paths', function () {
        $attrs = new OidcAttributes(['groups' => ['/ParentGroup/ChildGroup', '/StandaloneGroup']]);

        expect($attrs->asGroups('groups'))
            ->toContain('ParentGroup')
            ->toContain('ChildGroup')
            ->toContain('StandaloneGroup');
    });

    it('handles flat group names without slashes', function () {
        $attrs = new OidcAttributes(['groups' => ['Admin', 'Staff']]);

        expect($attrs->asGroups('groups'))->toBe(['Admin', 'Staff']);
    });

    // ------------------------------------------------------------------ //
    // all() / is_admin                                                    //
    // ------------------------------------------------------------------ //

    it('maps all attributes correctly', function () {
        $attrs = new OidcAttributes([
            'preferred_username' => 'jdoe@b-tu.de',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'groups' => ['Staff'],
            'roles' => ['editor'],
        ]);

        $result = $attrs->all();

        expect($result)->toMatchArray([
            'btu_id' => 'jdoe',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'groups' => ['Staff'],
            'roles' => ['editor'],
            'is_admin' => false,
        ]);
    });

    it('sets is_admin true when user belongs to the configured admin group', function () {
        config()->set('oidc.admin_group', 'Admin');

        $attrs = new OidcAttributes([
            'preferred_username' => 'admin@b-tu.de',
            'name' => 'Admin User',
            'email' => 'admin@b-tu.de',
            'groups' => ['Admin', 'Staff'],
            'roles' => [],
        ]);

        expect($attrs->all()['is_admin'])->toBeTrue();
    });

    it('respects a custom admin_group config value', function () {
        config()->set('oidc.admin_group', 'Superusers');

        $attrs = new OidcAttributes([
            'preferred_username' => 'su@b-tu.de',
            'name' => 'Super User',
            'email' => 'su@b-tu.de',
            'groups' => ['Superusers'],
            'roles' => [],
        ]);

        expect($attrs->all()['is_admin'])->toBeTrue();
    });

    it('sets is_admin false when user is not in the admin group', function () {
        config()->set('oidc.admin_group', 'Admin');

        $attrs = new OidcAttributes([
            'preferred_username' => 'user@b-tu.de',
            'name' => 'Regular User',
            'email' => 'user@b-tu.de',
            'groups' => ['Staff'],
            'roles' => [],
        ]);

        expect($attrs->all()['is_admin'])->toBeFalse();
    });
});
