<?php

namespace App\Data\User;

use App\Models\User;
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
class UserOneOrManyOnlyTrashedRequest extends Data
{
    #[Computed]
    #[Hidden]
    /** @var Collection<int, User> */
    public Collection $users;

    public function __construct(
        #[FromRouteParameter('user')]
        #[ExcludeWith('ids')]
        public ?int $user = null,

        #[Min(1)]
        #[RequiredWithout('user')]
        /** @var array<int> */
        public ?array $ids = null,
    ) {
        $this->users = User::query()
            ->onlyTrashed()
            ->when($user, fn (Builder $q) => $q->where('id', $user))
            ->when($ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $ids))
            ->get();
    }

    public static function attributes(): array
    {
        return [
            'user' => __('models.user.name.one'),
            'ids'  => __('models.user.name.many'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        $user = app(User::class);

        return [
            'ids.*' => ['integer', 'distinct', Rule::exists($user->getTable(), $user->getKeyName())],
        ];
    }
}
