<?php

namespace App\Traits;

use App\Enums\Role\RoleName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Permission\Traits\HasRoles as SpatieHasRoles;

/**
 * This trait is meant to group all role related logic for the user model.
 */
trait HasRoles
{
    use SpatieHasRoles;

    public static function bootHasRoles(): void {}

    public function initializeHasRoles(): void {}

    protected function isOwner(): Attribute
    {
        return Attribute::get(fn (): bool => $this->hasRole(RoleName::OWNER));
    }

    protected function isMember(): Attribute
    {
        return Attribute::get(fn (): bool => $this->hasRole(RoleName::MEMBER));
    }

    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereIsAdmin(true);
    }

    public function scopeOwners(Builder $query): Builder
    {
        return $query->role(RoleName::OWNER);
    }

    public function scopeMembers(Builder $query): Builder
    {
        return $query->role(RoleName::MEMBER);
    }
}
