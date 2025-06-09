<?php

namespace App\Data\User;

use App\Models\Team;
use App\Models\User;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserAbilitiesResource extends Resource
{
    public function __construct(
        public bool $view_any_teams,
        public bool $create_teams,
        public bool $view_any_users,
        public bool $create_users,
    ) {}

    public static function fromModel(User $user): self
    {
        return self::from([
            'view_any_teams' => $user->can('viewAny', Team::class),
            'create_teams'   => $user->can('create', Team::class),
            'view_any_users' => $user->can('viewAny', User::class),
            'create_users'   => $user->can('create', User::class),
        ]);
    }
}
