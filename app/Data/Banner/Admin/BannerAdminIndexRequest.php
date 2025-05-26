<?php

namespace App\Data\Banner\Admin;

use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class BannerAdminIndexRequest extends Data
{
    public function __construct(
        public ?string $q = null,
        public ?int $page = null,
        public ?int $per_page = null,
    ) {}

    public static function attributes(): array
    {
        return [
            'q'        => __('query'),
            'page'     => __('page'),
            'per_page' => __('per_page'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
