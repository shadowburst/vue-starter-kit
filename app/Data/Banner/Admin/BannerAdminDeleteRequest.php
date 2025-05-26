<?php

namespace App\Data\Banner\Admin;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\RequiredWithout;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class BannerAdminDeleteRequest extends Data
{
    #[Computed]
    /** @var Collection<int, Banner> */
    public Collection $banners;

    public function __construct(
        #[FromRouteParameter('banner')]
        public ?int $banner = null,

        #[Min(1)]
        #[RequiredWithout('banner')]
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
            'banner' => __('models.banner.name.singular'),
            'ids'    => __('models.banner.name.plural'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'ids.*' => ['integer', 'exists:banners,id'],
        ];
    }
}
