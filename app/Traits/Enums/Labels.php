<?php

namespace App\Traits\Enums;

trait Labels
{
    public static function bootLabels(): void {}

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
