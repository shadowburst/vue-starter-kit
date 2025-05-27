<?php

namespace App\Data\User\Admin;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\PaginatedDataCollection;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserAdminIndexProps extends Resource
{
    public function __construct(
        #[DataCollectionOf(UserAdminIndexResource::class)]
        public PaginatedDataCollection $users,
    ) {}
}
