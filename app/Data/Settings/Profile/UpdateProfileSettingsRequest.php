<?php

namespace App\Data\Settings\Profile;

use App\Models\User;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript, MergeValidationRules]
class UpdateProfileSettingsRequest extends Data
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        #[Email]
        public string $email,
    ) {}

    public static function attributes(): array
    {
        return [
            'first_name' => __('models.user.fields.first_name'),
            'last_name'  => __('models.user.fields.last_name'),
            'email'      => __('models.user.fields.email'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'email' => [Rule::unique(User::class)->ignore(request()->user())],
        ];
    }
}
