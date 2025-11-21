<?php

namespace App\Data\User\Member\Form;

use App\Attributes\Media;
use App\Data\User\Team\UserTeamPermissionData;
use App\Data\User\Team\UserTeamRoleData;
use App\Models\User;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\FromAuthenticatedUser;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\Hidden;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class UserMemberFormRequest extends Data
{
    public function __construct(
        #[Hidden]
        #[FromAuthenticatedUser]
        public User $owner,

        public string $first_name,

        public string $last_name,

        public string $email,

        public ?string $phone,

        #[Confirmed]
        #[Password(default: true)]
        public ?string $password,

        public ?string $password_confirmation,

        #[Media]
        public ?string $avatar,

        #[DataCollectionOf(UserTeamRoleData::class)]
        public DataCollection $team_roles,

        #[DataCollectionOf(UserTeamPermissionData::class)]
        public DataCollection $team_permissions,
    ) {}

    public static function attributes(): array
    {
        return [
            'avatar'                => __('models.user.fields.avatar'),
            'email'                 => __('models.user.fields.email'),
            'first_name'            => __('models.user.fields.first_name'),
            'last_name'             => __('models.user.fields.last_name'),
            'password'              => __('models.user.fields.password'),
            'password_confirmation' => __('models.user.fields.password_confirmation'),
            'phone'                 => __('models.user.fields.phone'),
            'team_permissions'      => __('models.user.fields.team_permissions'),
            'team_roles'            => __('models.user.fields.team_roles'),
        ];
    }

    public static function rules(ValidationContext $context, #[RouteParameter('member')] ?User $user): array
    {
        return [
            'password' => [Rule::requiredIf(! $user?->exists)],
        ];
    }
}
