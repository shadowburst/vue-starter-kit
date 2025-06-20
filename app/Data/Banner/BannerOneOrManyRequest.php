<?php

namespace App\Data\Banner;

use App\Models\Banner;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\ExcludeWith;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\RequiredWithout;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class BannerOneOrManyRequest extends Data
{
    public function __construct(
        #[FromRouteParameter('banner')]
        #[ExcludeWith('ids')]
        public ?int $banner = null,

        #[Min(1)]
        #[RequiredWithout('banner')]
        /** @var array<int> */
        public ?array $ids = null,
    ) {}

    public static function attributes(): array
    {
        return [
            'banner' => __('models.banner.name.one'),
            'ids'    => __('models.banner.name.many'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        $banner = app(Banner::class);

        return [
            'ids.*' => [
                'integer',
                'distinct',
                Rule::exists($banner->getTable(), $banner->getKeyName()),
            ],
        ];
    }
}
