<?php

namespace App\Services;

use App\Actions\Team\CreateOrUpdateTeam;
use App\Models\Team;

class TeamService
{
    protected ?Team $current = null;

    public function __construct(
        public CreateOrUpdateTeam $createOrUpdate,
    ) {}

    public function currentId(): ?int
    {
        $id = getPermissionsTeamId();

        if (! $id || is_string($id)) {
            return null;
        }

        return $id;
    }

    public function current(): ?Team
    {
        if (! $this->currentId()) {
            return null;
        }

        return $this->current ??= Team::query()
            ->withoutGlobalScopes()
            ->find($this->currentId());
    }

    public function setCurrent(Team|int|null $team = null): void
    {
        $isInstance = $team instanceof Team;
        setPermissionsTeamId(match (true) {
            $isInstance   => $team->id,
            is_int($team) => $team,
            default       => null
        });

        $this->current = $isInstance ? $team : null;
    }

    /**
     * Executes a callback with the given team set as current.
     *
     * @template TValue
     *
     * @param  (\Closure(Team $team): TValue)  $callback
     * @return TValue
     */
    public function forTeam(Team|int|null $team, \Closure $callback)
    {
        $tempTeam = $this->current;
        $this->setCurrent($team);

        $result = $callback($this->current());

        $this->setCurrent($tempTeam);

        return $result;
    }

    /**
     * Executes a callback for each given team.
     *
     * @template TValue
     *
     * @param  iterable<Team|int|null>  $teams
     * @param  (\Closure(Team $team): TValue)  $callback
     */
    public function forEachTeam(iterable $teams, \Closure $callback): void
    {
        foreach ($teams as $team) {
            $this->forTeam($team, $callback);
        }
    }
}
