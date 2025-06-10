<?php

namespace App\Data\Team\Index;

use Spatie\LaravelData\Attributes\AutoInertiaLazy;
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

        #[AutoInertiaLazy]
        #[DataCollectionOf(TeamIndexResource::class)]
        public Lazy|PaginatedDataCollection $teams,
    ) {}
}
