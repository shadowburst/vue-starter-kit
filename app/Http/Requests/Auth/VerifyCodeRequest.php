<?php

namespace App\Http\Requests\Auth;

use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Digits;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript, MergeValidationRules]
class VerifyCodeRequest extends Data
{
    public function __construct(
        #[Numeric, Digits(6)]
        public string $code,
    ) {}

    public static function attributes(): array
    {
        return [
            'code' => __('models.email_verification_token.fields.code'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
