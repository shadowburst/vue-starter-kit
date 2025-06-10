<?php

namespace App\Data\Team\Form;

use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class TeamFormRequest extends Data
{
    public function __construct(
        public string $name,
    ) {}

    public static function attributes(): array
    {
        return [
            //
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
