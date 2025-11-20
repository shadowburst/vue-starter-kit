<?php

namespace App\Transformers;

use Carbon\Carbon;
use DateTimeInterface;
use DateTimeZone;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

class TimestampMsTransformer implements Transformer
{
    public function __construct(
        protected ?string $setTimeZone = null,
    ) {}

    public function transform(DataProperty $property, mixed $value, TransformationContext $context): int
    {
        $this->setTimeZone ??= config('data.date_timezone');

        /** @var DateTimeInterface $value */
        if ($this->setTimeZone && $value instanceof Carbon) {
            $value = (clone $value)->setTimezone(new DateTimeZone($this->setTimeZone));
        }

        return Carbon::instance($value)->timestamp * 1000;
    }
}
