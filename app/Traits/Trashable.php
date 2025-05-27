<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

trait Trashable
{
    use SoftDeletes;

    /**
     * Boot the Trashable trait for a class.
     */
    public static function bootTrashable(): void {}

    /**
     * Initialize the Trashable trait for an instance.
     */
    public function initializeTrashable(): void {}

    protected function isTrashed(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->trashed(),
            set: fn (bool $value) => [
                $this->getDeletedAtColumn() => $value ? now() : null,
            ],
        );
    }

    #[Scope]
    protected function whereIsTrashed(Builder $query, bool $trashed = true): Builder
    {
        return $query->when(
            $trashed,
            fn (Builder $q) => $q->onlyTrashed(),
        );
    }
}
