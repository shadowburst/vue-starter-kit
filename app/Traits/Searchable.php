<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

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
    protected function scopeSearch(Builder $query): Builder
    {
        [$searchTerm, $attributes] = $this->parseArguments(func_get_args());

        if (! $searchTerm || ! $attributes) {
            return $query;
        }

        $searchTerm = strtolower($searchTerm);

        return $query->where(function (Builder $query) use ($attributes, $searchTerm) {
            foreach (Arr::wrap($attributes) as $attribute) {
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

    /**
     * Parse search scope arguments
     */
    private function parseArguments(array $arguments): array
    {
        $defaultQueryKey = 'q';

        $args_count = count($arguments);

        switch ($args_count) {
            case 1:
                return [request($defaultQueryKey), $this->getSearchableAttributes()];
                break;

            case 2:
                return is_string($arguments[1])
                    ? [$arguments[1], $this->getSearchableAttributes()]
                    : [request($defaultQueryKey), $arguments[1]];
                break;

            case 3:
                return is_string($arguments[1])
                    ? [$arguments[1], $arguments[2]]
                    : [$arguments[2], $arguments[1]];
                break;

            default:
                return [null, []];
                break;
        }
    }
}
