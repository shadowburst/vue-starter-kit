<?php

namespace App\Data\User;

use App\Models\User;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class UserFormRequest extends Data
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public ?string $phone,

        #[Confirmed]
        #[Password(default: true)]
        public ?string $password,
        public ?string $password_confirmation,
    ) {}

    public static function attributes(): array
    {
        return [
            //
        ];
    }

    public static function rules(ValidationContext $context, #[RouteParameter('user')] ?User $user): array
    {
        return [
            'password' => [Rule::requiredIf(! $user?->exists)],
        ];
    }
}
