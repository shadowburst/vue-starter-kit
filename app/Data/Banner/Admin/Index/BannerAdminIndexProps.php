<?php

namespace App\Data\Banner\Admin\Index;

use App\Data\Banner\BannerResource;
use Spatie\LaravelData\Attributes\AutoInertiaLazy;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\PaginatedDataCollection;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class BannerAdminIndexProps extends Resource
{
    public function __construct(
        #[AutoInertiaLazy]
        #[DataCollectionOf(BannerResource::class)]
        public Lazy|PaginatedDataCollection $banners,
    ) {}
}
