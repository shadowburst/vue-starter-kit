<?php

namespace App\Traits;

use App\Enums\Role\RoleName;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles as SpatieHasRoles;

/**
 * This trait is meant to group all role related logic for the user model.
 */
trait HasRoles
{
    use BelongsToOwner;
    use SpatieHasRoles;

    public static function bootHasRoles(): void {}

    public function initializeHasRoles(): void {}

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getOwnerIdColumn())->withDefault(fn (User $user, User $self) => $user->fill($self->getAttributes()));
    }

    protected function ownerId(): Attribute
    {
        return Attribute::make(
            get: fn (?int $value): int => $value ?? $this->getKey(),
            set: fn (?int $value) => $value == $this->getKey() ? null : $value,
        );
    }

    protected function isOwner(): Attribute
    {
        return Attribute::get(fn (): bool => $this->owner_id === $this->getKey());
    }

    protected function isMember(): Attribute
    {
        return Attribute::get(fn (): bool => ! $this->is_owner);
    }

    protected function isEditor(): Attribute
    {
        return Attribute::get(fn (): bool => $this->is_owner || $this->hasRole(RoleName::EDITOR));
    }

    public function unsetRolesAndPermissions(): void
    {
        $this->unsetRelation('roles')->unsetRelation('permissions');
    }

    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereIsAdmin(true);
    }

    public function scopeOwners(Builder $query): Builder
    {
        return $query->where(
            fn (Builder $q) => $q
                ->whereNull($this->getQualifiedOwnerIdColumn())
                ->orWhereColumn($this->getQualifiedKeyName(), $this->getQualifiedOwnerIdColumn()),
        );
    }

    public function scopeMembers(Builder $query): Builder
    {
        return $query->whereNot->owners();
    }

    public function scopeEditors(Builder $query): Builder
    {
        return $query->where(
            fn (Builder $q) => $q
                ->owners()
                ->orWhere->role(RoleName::EDITOR),
        );
    }
}
