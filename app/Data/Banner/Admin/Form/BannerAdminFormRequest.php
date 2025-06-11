<?php

namespace App\Data\Banner\Admin\Form;

use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
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
        public bool $is_enabled,
    ) {}

    public static function attributes(): array
    {
        return [
            'name'    => __('models.banner.fields.name'),
            'message' => __('models.banner.fields.message'),
            'action'  => __('models.banner.fields.action'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
