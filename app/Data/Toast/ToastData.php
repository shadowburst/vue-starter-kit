<?php

namespace App\Data\Toast;

use App\Enums\Toast\ToastType;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ToastData extends Resource
{
    public function __construct(
        public ToastType $type,

        public string $message,

        public ?string $title = null,

        public ?ToastActionData $action = null,
    ) {}
}
