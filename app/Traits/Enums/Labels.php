<?php

namespace App\Traits\Enums;

use Illuminate\Support\Collection;

trait Labels
{
    public static function bootLabels(): void {}

    public function initializeLabels(): void {}

    abstract public function label(): string;

    /**
     * @param  ?iterable<self|string>  $cases
     */
    public static function labels(?iterable $cases = null): array
    {
        return Collection::wrap($cases ?? self::cases())
            ->map(fn (self|string $value) => is_string($value) ? self::tryFrom($value) : $value)
            ->map(fn (self $value) => [
                'value' => $value->value,
                'label' => $value->label(),
            ])
            ->values()
            ->toArray();
    }
}
