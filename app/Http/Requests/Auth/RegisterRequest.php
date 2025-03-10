<?php

namespace App\Http\Requests\Auth;

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

#[TypeScript, MergeValidationRules]
class RegisterRequest extends Data
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        #[Email, Unique(User::class), Lowercase]
        public string $email,
        #[Confirmed, Password(min: 8)]
        public string $password,
    ) {}

    public static function attributes(): array
    {
        return [
            'first_name' => __('models.user.fields.first_name'),
            'last_name'  => __('models.user.fields.last_name'),
            'email'      => __('models.user.fields.email'),
            'password'   => __('models.user.fields.password'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
