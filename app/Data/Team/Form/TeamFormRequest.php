<?php

namespace App\Data\Team\Form;

use App\Models\Team;
use App\Models\User;
use Spatie\LaravelData\Attributes\FromAuthenticatedUser;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\Hidden;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class TeamFormRequest extends Data
{
    public function __construct(
        #[Hidden]
        #[FromAuthenticatedUser]
        public ?User $user,

        #[Hidden]
        #[FromRouteParameter('team')]
        public ?Team $team,

        public string $name,
    ) {}

    public static function attributes(): array
    {
        return [
            'name' => __('models.team.fields.name'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
