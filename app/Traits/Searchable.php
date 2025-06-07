<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function initializeSearchable(): void {}

    public static function bootSearchable(): void {}

    public function getSearchableAttributes(): array
    {
        return $this->searchable ?? [];
    }

    protected function scopeSearch(Builder $query, ?string $q): Builder
    {
        $attributes = $this->getSearchableAttributes();

        if (! $q || empty($attributes)) {
            return $query;
        }

        $searchTerm = strtolower($q);

        return $query->where(function (Builder $query) use ($attributes, $searchTerm) {
            foreach ($attributes as $attribute) {
                $query->when(
                    str_contains($attribute, '.'),
                    function (Builder $query) use ($attribute, $searchTerm) {
                        $parts = explode('.', $attribute);
                        $relationAttribute = array_pop($parts);
                        $relationName = implode('.', $parts);

                        $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                            $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                        });
                    },
                    function (Builder $query) use ($attribute, $searchTerm) {
                        $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                    },
                );
            }
        });
    }
}
