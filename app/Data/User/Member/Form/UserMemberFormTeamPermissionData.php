<?php

namespace App\Data\User\Member\Form;

use App\Enums\Permission\PermissionName;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class UserMemberFormTeamPermissionData extends Data
{
    public function __construct(
        public int $team_id,
        public PermissionName $permission,
    ) {}

    public static function attributes(): array
    {
        return [
            'team_id'    => __('models.team.name.one'),
            'permission' => __('models.permission.name.one'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'team_id' => [Rule::in(Auth::user()->teams->where('can_update', true)->pluck('id'))],
        ];
    }
}
