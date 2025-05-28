<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class AddressData extends Data
{
    #[Computed]
    public string $full;

    public function __construct(
        public string $line_1,
        public ?string $line_2,
        public string $postal_code,
        public string $city,
        public string $country,
        public ?string $lat,
        public ?string $lng,
    ) {
        $this->full = implode(', ', [implode(' ', array_filter([$line_1, $line_2])), implode(' ', [$postal_code, $city]), $country]);
    }

    public static function attributes(): array
    {
        return [
            'line_1'      => __('data.address.fields.line_1'),
            'line_2'      => __('data.address.fields.line_2'),
            'postal_code' => __('data.address.fields.postal_code'),
            'city'        => __('data.address.fields.city'),
            'country'     => __('data.address.fields.country'),
            'lat'         => __('data.address.fields.lat'),
            'lng'         => __('data.address.fields.lng'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
