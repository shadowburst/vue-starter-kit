<?php

namespace App\Data\User\Member;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\FromRouteParameterProperty;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\ExcludeWith;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\RequiredWithout;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class UserMemberOneOrManyRequest extends Data
{
    public function __construct(
        #[FromRouteParameterProperty('member', 'id')]
        #[ExcludeWith('ids')]
        public ?int $user = null,

        #[Min(1)]
        #[RequiredWithout('user')]
        /** @var array<int> */
        public ?array $ids = null,
    ) {}

    public static function attributes(): array
    {
        return [
            'user' => __('models.user.member.name.one'),
            'ids'  => __('models.user.member.name.many'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        $user = app(User::class);

        return [
            'ids.*' => [
                'integer',
                'distinct',
                Rule::exists($user->getTable(), $user->getKeyName())
                    ->where($user->getOwnerIdColumn(), Auth::user()->getKey()),
            ],
        ];
    }
}
