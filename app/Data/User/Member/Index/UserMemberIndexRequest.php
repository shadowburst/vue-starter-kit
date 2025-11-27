<?php

namespace App\Data\User\Member\Index;

use App\Data\Support\SortFieldData;
use App\Enums\Trashed\TrashedFilter;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class UserMemberIndexRequest extends Data
{
    public function __construct(
        public ?int $page = null,

        public ?int $per_page = null,

        #[DataCollectionOf(SortFieldData::class)]
        public ?DataCollection $sort = null,

        public ?string $q = null,

        public ?TrashedFilter $trashed = null,
    ) {}

    public static function attributes(): array
    {
        return [
            'q'        => __('query'),
            'page'     => __('page'),
            'per_page' => __('per_page'),
            'sort'     => __('sort'),
            'trashed'  => __('models.user.fields.is_trashed'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            //
        ];
    }
}
