<?php

namespace App\Data\Team\Index;

use App\Attributes\EnumArrayOf;
use App\Data\Team\TeamResource;
use App\Enums\Trashed\TrashedFilter;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\PaginatedDataCollection;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TeamIndexProps extends Resource
{
    public function __construct(
        public TeamIndexRequest $request,

        #[DataCollectionOf(TeamResource::class)]
        public Lazy|PaginatedDataCollection $teams,

        #[EnumArrayOf(TrashedFilter::class)]
        public Lazy|array $trashedFilters,
    ) {}
}
