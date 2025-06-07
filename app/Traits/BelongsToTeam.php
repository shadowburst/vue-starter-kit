<?php

namespace App\Traits;

use App\Models\Scopes\BelongsToCurrentTeam;
use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTeam
{
    public static function bootBelongsToTeam(): void
    {
        static::addGlobalScope(BelongsToCurrentTeam::class);

        static::creating(function (Model $model) {
            $teamService = app(TeamService::class);

            $model->{$model->getTeamIdColumn()} ??= $teamService->currentId();
        });
    }

    public function initializeBelongsToTeam(): void {}

    public function getTeamIdColumn(): string
    {
        return defined(static::class.'::TEAM_ID') ? static::TEAM_ID : 'team_id';
    }

    public function getQualifiedTeamIdColumn(): string
    {
        return $this->qualifyColumn($this->getTeamIdColumn());
    }

    public function isSameTeam(Team|int $team): bool
    {
        $team = is_int($team) ? $team : $team->getKey();

        return $this->{$this->getTeamIdColumn()} == $team;
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, $this->getTeamIdColumn());
    }

    public function scopeWhereBelongsToTeam(Builder $query, Team|int $team): Builder
    {
        $team = is_int($team) ? $team : $team->getKey();

        return $query->where(
            fn (Builder $q) => $q
                ->whereNull($this->getQualifiedTeamIdColumn())
                ->orWhere($this->getQualifiedTeamIdColumn(), $team),
        );
    }
}
