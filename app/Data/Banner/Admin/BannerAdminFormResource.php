<?php

namespace App\Data\Banner\Admin;

use Carbon\Carbon;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class BannerAdminFormResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public string $message,
        public ?string $action,
        public Carbon $start_date,
        public Carbon $end_date,
    ) {}
}
