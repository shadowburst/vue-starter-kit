<?php

namespace App\Traits\Enums;

trait Labels
{
    /**
     * Boot the Labels trait for a class.
     */
    public static function bootLabels(): void {}

    /**
     * Initialize the Labels trait for an instance.
     */
    public function initializeLabels(): void {}

    abstract public function label(): string;

    public static function labels(?array $cases = null): array
    {
        return collect($cases ?? self::cases())
            ->map(fn (self $value) => [
                'value' => $value->value,
                'label' => $value->label(),
            ])
            ->values()
            ->toArray();
    }
}
