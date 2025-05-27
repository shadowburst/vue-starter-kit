<?php

namespace App\Data\Banner\Admin;

use Carbon\Carbon;
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
        public ?Carbon $start_date = null,
        public ?Carbon $end_date = null,
        public ?bool $is_enabled = null,
        public ?int $page = null,
        public ?int $per_page = null,
        public string $sort_by = 'id',
        public string $sort_direction = 'desc',
    ) {}

    public static function attributes(): array
    {
        return [
            'q'              => __('query'),
            'page'           => __('page'),
            'per_page'       => __('per_page'),
            'sort_by'        => __('sort_by'),
            'sort_direction' => __('sort_direction'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
