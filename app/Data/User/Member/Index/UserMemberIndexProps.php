<?php

namespace App\Data\User\Member\Index;

use App\Attributes\EnumArrayOf;
use App\Enums\Trashed\TrashedFilter;
use Spatie\LaravelData\Attributes\AutoInertiaLazy;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\PaginatedDataCollection;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserMemberIndexProps extends Resource
{
    public function __construct(
        public UserMemberIndexRequest $request,

        #[AutoInertiaLazy]
        #[DataCollectionOf(UserMemberIndexResource::class)]
        public Lazy|PaginatedDataCollection $users,

        #[AutoInertiaLazy]
        #[EnumArrayOf(TrashedFilter::class)]
        public Lazy|array $trashedFilters,
    ) {}
}
