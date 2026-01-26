<?php

namespace App\Data\Toast;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ToastActionData extends Resource
{
    public function __construct(
        public string $label,

        public string $url,
    ) {}
}
