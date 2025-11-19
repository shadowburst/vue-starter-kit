<?php

namespace App\Data\Auth;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Features;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;
use Spatie\TypeScriptTransformer\Attributes\TypeScriptType;

#[TypeScript]
class AuthAbilitiesResource extends Resource
{
    #[Computed]
    public bool $register;

    #[Computed]
    public bool $verify_email;

    #[Computed]
    #[TypeScriptType([
        'view_any' => 'bool',
        'create'   => 'bool',
    ])]
    public array $teams;

    #[Computed]
    #[TypeScriptType([
        'view_any' => 'bool',
        'create'   => 'bool',
    ])]
    public array $users;

    public function __construct()
    {
        $this->register = Features::enabled(Features::registration());
        $this->verify_email = Features::enabled(Features::emailVerification());

        $this->teams = [
            'view_any' => Gate::check('viewAny', Team::class),
            'create'   => Gate::check('create', Team::class),
        ];
        $this->users = [
            'view_any' => Gate::check('viewAny', User::class),
            'create'   => Gate::check('create', User::class),
        ];
    }
}
