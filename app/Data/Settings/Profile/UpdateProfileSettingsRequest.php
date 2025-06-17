<?php

namespace App\Data\Settings\Profile;

use App\Attributes\Media;
use App\Models\User;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\FromAuthenticatedUser;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\Hidden;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class UpdateProfileSettingsRequest extends Data
{
    public function __construct(
        #[Hidden]
        #[FromAuthenticatedUser]
        public User $user,

        public string $first_name,
        public string $last_name,
        public ?string $phone,

        #[Email]
        public string $email,

        #[Media]
        public ?string $avatar,

    ) {}

    public static function attributes(): array
    {
        return [
            'first_name' => __('models.user.fields.first_name'),
            'last_name'  => __('models.user.fields.last_name'),
            'phone'      => __('models.user.fields.phone'),
            'email'      => __('models.user.fields.email'),
            'avatar'     => __('models.user.fields.avatar'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'email' => [Rule::unique(User::class)->ignore(request()->user())],
        ];
    }
}
