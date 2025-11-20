<?php

namespace App\Casts;

use Carbon\Carbon;
use DateTimeInterface;
use DateTimeZone;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\IterableItemCast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Exceptions\CannotCastDate;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class TimestampMsCast implements Cast, IterableItemCast
{
    public function __construct(
        protected ?string $type = null,
        protected ?string $setTimeZone = null,
        protected ?string $timeZone = null,
    ) {}

    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): DateTimeInterface|Uncastable
    {
        return $this->castValue($this->type ?? $property->type->type->findAcceptedTypeForBaseType(DateTimeInterface::class), $value);
    }

    public function castIterableItem(DataProperty $property, mixed $value, array $properties, CreationContext $context): DateTimeInterface|Uncastable
    {
        return $this->castValue($property->type->iterableItemType, $value);
    }

    protected function castValue(
        ?string $type,
        mixed $value,
    ): Uncastable|null|DateTimeInterface {
        $formats = collect($this->format ?? config('data.date_format'));

        if ($type === null) {
            return Uncastable::create();
        }

        /** @var DateTimeInterface|null $datetime */
        $datetime = rescue(fn () => $type::createFromTimestampMs((int) $value, isset($this->timeZone) ? new DateTimeZone($this->timeZone) : null), report: false);

        if (! $datetime) {
            throw CannotCastDate::create($formats->toArray(), $type, $value);
        }

        $this->setTimeZone ??= config('data.date_timezone');

        if ($this->setTimeZone && $datetime instanceof Carbon) {
            return $datetime->setTimezone(new DateTimeZone($this->setTimeZone));
        }

        return $datetime;
    }
}
