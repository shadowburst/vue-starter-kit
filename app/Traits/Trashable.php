<?php

namespace App\Traits;

use App\Enums\Trashed\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

trait Trashable
{
    use SoftDeletes;

    public static function bootTrashable(): void {}

    public function initializeTrashable(): void {}

    protected function isTrashable(): Attribute
    {
        return Attribute::get(fn (): true => true);
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

    protected function scopeFilterTrashed(Builder $query, TrashedFilter $filter): Builder
    {
        return match ($filter) {
            TrashedFilter::ONLY => $query->onlyTrashed(),
            TrashedFilter::WITH => $query->withTrashed(),
            default             => $query
        };
    }
}
