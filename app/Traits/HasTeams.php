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
    public static function bootHasTeams(): void {}

    public function initializeHasTeams(): void {}

    public function teams(): MorphToMany
    {
        return $this->morphToMany(Team::class, 'model', 'model_has_roles')
            ->distinct();
    }

    /**
     * @param  int|array|Team|Collection  $teams
     */
    public function hasTeam($teams): bool
    {
        $this->load(['teams' => fn (MorphToMany $q) => $q->withTrashed()]);

        if (is_int($teams)) {
            return $this->teams->contains('id', $teams);
        }

        if ($teams instanceof Team) {
            return $this->teams->contains($teams->getKeyName(), $teams->getKey());
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
            return $teams->intersect($this->teams)->isNotEmpty();
        }

        throw new \TypeError('Unsupported type for $teams parameter to hasTeam().');
    }
}
