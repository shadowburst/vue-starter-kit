<?php

namespace App\Data\Team;

use App\Models\Team;
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
class TeamOneOrManyOnlyTrashedRequest extends Data
{
    #[Computed]
    #[Hidden]
    /** @var Collection<int, Team> */
    public Collection $teams;

    public function __construct(
        #[FromRouteParameter('team')]
        #[ExcludeWith('ids')]
        public ?int $team = null,

        #[Min(1)]
        #[RequiredWithout('team')]
        /** @var array<int> */
        public ?array $ids = null,
    ) {
        $this->teams = Team::query()
            ->onlyTrashed()
            ->when($team, fn (Builder $q) => $q->where('id', $team))
            ->when($ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $ids))
            ->get();
    }

    public static function attributes(): array
    {
        return [
            'team' => __('models.team.name.one'),
            'ids'  => __('models.team.name.many'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        $team = app(Team::class);

        return [
            'ids.*' => ['integer', 'distinct', Rule::exists($team->getTable(), $team->getKeyName())],
        ];
    }
}
