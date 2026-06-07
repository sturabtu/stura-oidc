<?php

namespace StuRaBtu\Oidc\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use StuRaBtu\Oidc\Casts\AsRolesCollection;
use StuRaBtu\Oidc\Enums\Role;

abstract class OidcUser extends Authenticatable implements FilamentUser
{
    use Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'scoped_affiliations' => AsCollection::class,
            'identifiers' => AsCollection::class,
            'entitlements' => AsCollection::class,
            'groups' => AsCollection::class,
            'roles' => AsRolesCollection::class,
            'password' => 'hashed',
        ];
    }

    /**
     * @return Attribute<bool,never>
     */
    protected function isAdmin(): Attribute
    {
        return Attribute::get(
            fn () => $this->roles->contains(Role::GLOBAL_ADMIN) ?? false,
        );
    }

    /**
     * @return Attribute<bool,never>
     */
    protected function canAccessApplication(): Attribute
    {
        return Attribute::get(fn () => $this->isAdmin);
    }

    /**
     * Get the user's entitlements.
     *
     * @return Collection<int, string>
     */
    public function entitlements(string $prefix): Collection
    {
        return $this->entitlements
            ->filter(fn (string $entitlement) => str_starts_with($entitlement, $prefix))
            ->values();
    }
}
