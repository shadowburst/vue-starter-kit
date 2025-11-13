<?php

namespace App\Data\Team;

use App\Attributes\ModelPolicy;
use App\Data\Media\MediaResource;
use App\Data\User\UserResource;
use App\Models\Team;
use App\Traits\WithModel;
use Carbon\Carbon;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TeamResource extends Resource
{
    use WithModel;

    protected string $modelClass = Team::class;

    public function __construct(
        public int $id,

        public string $name,

        public ?TeamSettingsData $settings,

        public ?Carbon $deleted_at,

        public Lazy|null|UserResource $creator,

        public Lazy|null|MediaResource $logo,

        #[ModelPolicy(Team::class)]
        public Lazy|array $policy,
    ) {}

    public static function fromModel(Team $team): static
    {
        $dto = new static(
            id         : $team->id,
            name       : $team->name,
            settings   : $team->settings,
            deleted_at : $team->deleted_at,
            creator    : Lazy::create(fn () => $team->creator ? UserResource::from($team->creator) : null),
            logo       : Lazy::create(fn () => $team->logo ? MediaResource::from($team->logo) : null),
            policy     : Lazy::create(fn () => $team->policy),
        );

        $dto->model = $team;

        return $dto;
    }
}
