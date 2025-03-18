<?php

namespace App\Http\Requests\Auth;

use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript, MergeValidationRules]
class NewPasswordRequest extends Data
{
    public function __construct(
        public string $token,
        public string $email,
        #[Confirmed, Password(default: true)]
        public string $password,
        public string $password_confirmation,
    ) {}

    public static function attributes(): array
    {
        return [
            'email'                 => __('models.user.fields.email'),
            'password'              => __('models.user.fields.password'),
            'password_confirmation' => __('models.user.fields.password'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
