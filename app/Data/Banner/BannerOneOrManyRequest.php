<?php

namespace App\Data\Banner;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\ExcludeWith;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\RequiredWithout;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\Hidden;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class BannerOneOrManyRequest extends Data
{
    #[Computed]
    #[Hidden]
    /** @var Collection<int, Banner> */
    public Collection $banners;

    public function __construct(
        #[FromRouteParameter('banner')]
        #[ExcludeWith('ids')]
        public ?int $banner = null,

        #[Min(1)]
        #[RequiredWithout('banner')]
        /** @var array<int> */
        public ?array $ids = null,
    ) {
        $this->banners = Banner::query()
            ->when($banner, fn (Builder $q) => $q->where('id', $banner))
            ->when($ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $ids))
            ->get();
    }

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
            'ids.*' => ['integer', Rule::exists($banner->getTable(), $banner->getKeyName())],
        ];
    }
}
