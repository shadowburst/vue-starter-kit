<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Searchable
 */
trait Searchable
{
    /**
     * Boot The Searchable trait for an instance.
     */
    public function initializeSearchable(): void {}

    /**
     * Initialize the Searchable trait for a class.
     */
    public static function bootSearchable(): void {}

    /**
     * Gets the searchable attributes.
     */
    public function getSearchableAttributes(): array
    {
        return $this->searchable ?? [];
    }

    /**
     * Scope a query to search for a term in the attributes
     */
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
