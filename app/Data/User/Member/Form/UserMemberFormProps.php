<?php

namespace App\Data\User\Member\Form;

use App\Attributes\EnumArrayOf;
use App\Data\Team\TeamResource;
use App\Data\User\UserResource;
use App\Enums\Permission\PermissionName;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserMemberFormProps extends Resource
{
    public function __construct(
        public ?UserResource $user,

        #[DataCollectionOf(TeamResource::class)]
        public Lazy|DataCollection $teams,

        #[EnumArrayOf(PermissionName::class)]
        public Lazy|array $permissions,
    ) {}
}
