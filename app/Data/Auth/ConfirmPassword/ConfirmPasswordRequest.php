<?php

namespace App\Data\Auth\ConfirmPassword;

use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript, MergeValidationRules]
class ConfirmPasswordRequest extends Data
{
    public function __construct(
        public string $password,
    ) {}

    public static function attributes(): array
    {
        return [
            'password' => __('models.user.fields.password'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
