<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ToastMessagesData extends Data
{
    public function __construct(
        public ?string $info,
        public ?string $success,
        public ?string $warning,
        public ?string $error,
    ) {}
}
