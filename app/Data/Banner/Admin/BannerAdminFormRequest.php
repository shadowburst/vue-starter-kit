<?php

namespace App\Data\Banner\Admin;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\After;
use Spatie\LaravelData\Attributes\Validation\Before;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\References\FieldReference;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class BannerAdminFormRequest extends Data
{
    public function __construct(
        public string $name,
        public string $message,
        public ?string $action,
        #[Before(new FieldReference('end_date'))]
        public Carbon $start_date,
        #[After(new FieldReference('start_date'))]
        public Carbon $end_date,
        public bool $is_enabled,
    ) {}

    public static function attributes(): array
    {
        return [
            'name'       => __('models.banner.fields.name'),
            'message'    => __('models.banner.fields.message'),
            'action'     => __('models.banner.fields.action'),
            'start_date' => __('models.banner.fields.from'),
            'end_date'   => __('models.banner.fields.to'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
