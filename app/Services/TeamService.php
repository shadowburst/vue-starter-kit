<?php

namespace App\Services;

use App\Models\Team;

class TeamService
{
    protected ?Team $current = null;

    public function __construct(
        //
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
    public function forTeam(Team|int $team, \Closure $callback)
    {
        $tempTeam = $this->current;
        $this->setCurrent($team);

        $result = $callback($this->current());

        $this->setCurrent($tempTeam);

        return $result;
    }
}
