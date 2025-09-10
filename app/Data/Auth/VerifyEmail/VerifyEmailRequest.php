<?php

namespace App\Data\Auth\VerifyEmail;

use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Digits;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class VerifyEmailRequest extends Data
{
    public function __construct(
        #[Numeric]
        #[Digits(6)]
        public string $code,
    ) {}

    public static function attributes(): array
    {
        return [
            'code' => __('code'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
