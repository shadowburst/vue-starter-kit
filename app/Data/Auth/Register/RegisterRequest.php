<?php

namespace App\Data\Auth\Register;

use App\Models\User;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Lowercase;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class RegisterRequest extends Data
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $phone,
        #[Email, Unique(User::class), Lowercase]
        public string $email,
        #[Confirmed, Password(default: true)]
        public string $password,
        public string $password_confirmation,
    ) {}

    public static function attributes(): array
    {
        return [
            'first_name'            => __('models.user.fields.first_name'),
            'last_name'             => __('models.user.fields.last_name'),
            'phone'                 => __('models.user.fields.phone'),
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
