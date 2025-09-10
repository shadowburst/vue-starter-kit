<?php

namespace App\Data\Auth\Login;

use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class LoginRequest extends Data
{
    public function __construct(
        #[Email]
        public string $email,

        public string $password,

        public ?bool $remember = false,
    ) {}

    public static function attributes(): array
    {
        return [
            'email'    => __('models.user.fields.email'),
            'password' => __('models.user.fields.password'),
            'remember' => __('models.user.fields.remember'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
