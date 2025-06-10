<?php

namespace App\Data\User\Member\Form;

use App\Attributes\EnumArrayOf;
use App\Data\Team\TeamListResource;
use App\Enums\Permission\PermissionName;
use Spatie\LaravelData\Attributes\AutoInertiaLazy;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserMemberFormProps extends Resource
{
    public function __construct(
        public ?UserMemberFormResource $user,

        #[AutoInertiaLazy]
        #[DataCollectionOf(TeamListResource::class)]
        public Lazy|DataCollection $teams,

        #[AutoInertiaLazy]
        #[EnumArrayOf(PermissionName::class)]
        public Lazy|array $permissions,
    ) {}
}
