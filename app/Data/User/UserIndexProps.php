<?php

namespace App\Data\User;

use Spatie\LaravelData\Attributes\AutoInertiaLazy;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\PaginatedDataCollection;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserIndexProps extends Resource
{
    public function __construct(
        public UserIndexRequest $request,

        #[AutoInertiaLazy]
        #[DataCollectionOf(UserIndexResource::class)]
        public Lazy|PaginatedDataCollection $users,
    ) {}
}
