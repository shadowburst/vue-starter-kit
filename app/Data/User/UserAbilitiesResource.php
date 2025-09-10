<?php

namespace App\Data\User;

use App\Models\Team;
use App\Models\User;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;
use Spatie\TypeScriptTransformer\Attributes\TypeScriptType;

#[TypeScript]
class UserAbilitiesResource extends Resource
{
    public function __construct(
        #[TypeScriptType([
            'view_any' => 'bool',
            'create'   => 'bool',
        ])]
        public array $teams,

        #[TypeScriptType([
            'view_any' => 'bool',
            'create'   => 'bool',
        ])]
        public array $users,
    ) {}

    public static function fromModel(User $user): self
    {
        return self::from([
            'teams' => [
                'view_any' => $user->can('viewAny', Team::class),
                'create'   => $user->can('create', Team::class),
            ],
            'users' => [
                'view_any' => $user->can('viewAny', User::class),
                'create'   => $user->can('create', User::class),
            ],
        ]);
    }
}
