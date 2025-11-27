<?php

namespace App\Data\Support;

use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class SortFieldData extends Data
{
    public function __construct(
        public string $id,
        public bool $desc = false,
    ) {}
}
