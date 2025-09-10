<?php

namespace App\Data\Banner\Admin\Form;

use App\Data\Banner\BannerResource;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class BannerAdminFormProps extends Resource
{
    public function __construct(
        public ?BannerResource $banner,
    ) {}
}
