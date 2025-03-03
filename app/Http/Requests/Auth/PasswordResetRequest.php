<?php

namespace App\Http\Requests\Auth;

use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript, MergeValidationRules]
class PasswordResetRequest extends Data
{
    public function __construct(
        #[Email]
        public string $email,
    ) {}

    public static function attributes(): array
    {
        return [
            'email' => __('models.user.fields.email'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
