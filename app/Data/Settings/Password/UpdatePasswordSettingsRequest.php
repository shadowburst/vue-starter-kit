<?php

namespace App\Data\Settings\Password;

use App\Models\User;
use Spatie\LaravelData\Attributes\FromAuthenticatedUser;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\CurrentPassword;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\Hidden;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class UpdatePasswordSettingsRequest extends Data
{
    public function __construct(
        #[Hidden]
        #[FromAuthenticatedUser]
        public User $user,

        #[CurrentPassword]
        public string $current_password,

        #[Confirmed, Password(default: true)]
        public string $password,
        public string $password_confirmation,
    ) {}

    public static function attributes(): array
    {
        return [
            'current_password'      => __('models.user.fields.current_password'),
            'password'              => __('models.user.fields.password'),
            'password_confirmation' => __('models.user.fields.password_confirmation'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
