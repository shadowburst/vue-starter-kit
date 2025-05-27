<?php

namespace App\Data\User\Admin;

use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class UserAdminFormRequest extends Data
{
    public function __construct(
        //
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
