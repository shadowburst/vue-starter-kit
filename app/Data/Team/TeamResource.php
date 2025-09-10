<?php

namespace App\Data\Team;

use App\Data\Media\MediaResource;
use App\Data\User\UserResource;
use App\Models\Team;
use Carbon\Carbon;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TeamResource extends Resource
{
    public function __construct(
        public int $id,

        public string $name,

        public ?TeamSettingsData $settings,

        public ?Carbon $deleted_at,

        public Lazy|bool $can_view,

        public Lazy|bool $can_update,

        public Lazy|bool $can_trash,

        public Lazy|bool $can_restore,

        public Lazy|bool $can_delete,

        public Lazy|Optional|UserResource $creator,

        public Lazy|Optional|MediaResource $logo,
    ) {}

    public static function fromModel(Team $team): static
    {
        return static::from([
            'id'          => $team->id,
            'name'        => $team->name,
            'settings'    => $team->settings,
            'deleted_at'  => $team->deleted_at,
            'can_view'    => Lazy::create(fn () => $team->can_view),
            'can_update'  => Lazy::create(fn () => $team->can_update),
            'can_trash'   => Lazy::create(fn () => $team->can_trash),
            'can_restore' => Lazy::create(fn () => $team->can_restore),
            'can_delete'  => Lazy::create(fn () => $team->can_delete),
            'creator'     => Lazy::create(fn () => $team->creator ? UserResource::from($team->creator) : Optional::create()),
            'logo'        => Lazy::create(fn () => $team->logo ? MediaResource::from($team->logo) : Optional::create()),
        ]);
    }
}
