<?php

namespace App\Traits;

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
        return Attribute::get(fn (): bool => is_null($this->owner_id));
    }

    protected function isMember(): Attribute
    {
        return Attribute::get(fn (): bool => ! $this->is_owner);
    }

    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereIsAdmin(true);
    }

    public function scopeOwners(Builder $query): Builder
    {
        return $query->whereNull($this->getQualifiedOwnerIdColumn());
    }

    public function scopeMembers(Builder $query): Builder
    {
        return $query->whereNot(fn (Builder $q) => $q->owners());
    }
}
