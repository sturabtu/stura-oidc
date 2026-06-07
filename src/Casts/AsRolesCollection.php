<?php

namespace StuRaBtu\Oidc\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use StuRaBtu\Oidc\Enums\Role;

class AsRolesCollection implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null || $value === '' || $value === '[]') {
            return collect();
        }

        return collect(json_decode($value, true))
            ->map(fn (string $role) => Role::tryFrom($role))
            ->filter()
            ->values();
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return Collection::wrap($value)
            ->map(fn (Role|string $role) => is_string($role) ? Role::tryFrom($role) : $role)
            ->filter()
            ->map(fn (Role $role) => $role->value)
            ->values()
            ->toJson();
    }
}
