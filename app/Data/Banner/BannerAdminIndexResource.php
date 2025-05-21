<?php

namespace App\Data\Banner;

use Carbon\Carbon;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class BannerAdminIndexResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public Carbon $start_date,
        public Carbon $end_date,
    ) {}
}
