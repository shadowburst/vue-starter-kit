<?php

namespace App\Data\Banner\Admin;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\PaginatedDataCollection;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class BannerAdminIndexProps extends Resource
{
    public function __construct(
        #[DataCollectionOf(BannerAdminIndexResource::class)]
        public PaginatedDataCollection $banners,
    ) {}
}
