<?php

namespace App\Traits\Models;

use App\Models\Scopes\BelongsToAuthTeam;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTeam
{
    public static function bootBelongsToTeam(): void
    {
        static::addGlobalScope(BelongsToAuthTeam::class);
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

    public function isSameTeam(Team|int|null $team): bool
    {
        if (is_null($team)) {
            return false;
        }

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

        return $query
            ->whereBelongsToAnyTeam()
            ->where(
                fn (Builder $q) => $q
                    ->whereNull($this->getQualifiedTeamIdColumn())
                    ->orWhere($this->getQualifiedTeamIdColumn(), $team),
            );
    }
}
