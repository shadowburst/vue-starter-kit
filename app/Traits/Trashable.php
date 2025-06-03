<?php

namespace App\Traits;

use App\Enums\Trashed\TrashedFilter;
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

    protected function isTrashable(): Attribute
    {
        return Attribute::get(fn () => true);
    }

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
    protected function filterTrashed(Builder $query, TrashedFilter $filter): Builder
    {
        return match ($filter) {
            TrashedFilter::ONLY => $query->onlyTrashed(),
            TrashedFilter::WITH => $query->withTrashed(),
            default             => $query
        };
    }
}
