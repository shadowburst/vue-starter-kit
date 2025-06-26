<?php

namespace App\Traits;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * This trait is meant to group all team related logic for the user model.
 */
trait HasTeams
{
    use BelongsToTeam;

    public static function bootHasTeams(): void {}

    public function initializeHasTeams(): void {}

    public function teams(): MorphToMany
    {
        return $this->morphToMany(Team::class, 'model', 'model_has_roles')
            ->distinct();
    }

    public function trashedTeams(): MorphToMany
    {
        return $this->teams()
            ->onlyTrashed();
    }

    /**
     * @param  string|int|array|Team|Collection  $teams
     */
    public function hasTeam($teams): bool
    {
        $this->loadMissing(['teams', 'trashedTeams']);

        $modelTeams = Collection::wrap($this->teams)->merge($this->trashedTeams);

        if (is_int($teams) || is_string($teams)) {
            return $modelTeams->contains('id', $teams);
        }

        if ($teams instanceof Team) {
            return $modelTeams->contains($teams->getKeyName(), $teams->getKey());
        }

        if (is_array($teams)) {
            foreach ($teams as $team) {
                if ($this->hasTeam($team)) {
                    return true;
                }
            }

            return false;
        }

        if ($teams instanceof Collection) {
            return $teams->intersect($modelTeams)->isNotEmpty();
        }

        throw new \TypeError('Unsupported type for $teams parameter to hasTeam().');
    }
}
