<?php

namespace App\Models\Scopes;

use App\Services\TeamService;
use App\Traits\Models\BelongsToTeam;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class BelongsToAuthTeam implements Scope
{
    public function apply(Builder $query, Model $model): Builder
    {
        if (! in_array(BelongsToTeam::class, class_uses_recursive($model))) {
            return $query;
        }

        if (App::runningInConsole()) {
            return $query;
        }

        if (Route::is('admin.*')) {
            return $query;
        }

        $team = app(TeamService::class)->currentId();
        if (! $team) {
            return $query;
        }

        return $query->whereBelongsToTeam($team);
    }

    public function extend(Builder $query): void
    {
        $query->macro(
            'whereBelongsToAnyTeam',
            fn (Builder $q) => $q->withoutGlobalScope($this),
        );
    }
}
