<?php

namespace App\Traits;

use App\Models\Scopes\BelongsToCurrentOwner;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToOwner
{
    public static function bootBelongsToOwner(): void
    {
        static::addGlobalScope(BelongsToCurrentOwner::class);
    }

    public function initializeBelongsToOwner(): void {}

    public function getOwnerIdColumn(): string
    {
        return defined(static::class.'::OWNER_ID') ? static::OWNER_ID : 'owner_id';
    }

    public function getQualifiedOwnerIdColumn(): string
    {
        return $this->qualifyColumn($this->getOwnerIdColumn());
    }

    public function isSameOwner(User|int $owner): bool
    {
        $owner = is_int($owner) ? $owner : $owner->getKey();

        return $this->{$this->getOwnerIdColumn()} == $owner;
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getOwnerIdColumn());
    }

    public function scopeWhereBelongsToOwner(Builder $query, User|int $owner): Builder
    {
        $owner = is_int($owner) ? $owner : $owner->getKey();

        return $query->where(
            fn (Builder $q) => $q
                ->whereNull($this->getQualifiedOwnerIdColumn())
                ->orWhere($this->getQualifiedOwnerIdColumn(), $owner),

        );
    }
}
