<?php

namespace App\Http\Middleware\Auth;

use App\Actions\User\SelectUserTeam;
use App\Http\Controllers\Team\TeamFirstController;
use App\Models\Team;
use App\Services\TeamService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthTeamMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        abort_if(! $user, Response::HTTP_FORBIDDEN);

        /** @var \App\Models\User $user */
        $team = $user->team_id && $user->hasTeam($user->team_id)
            ? $user->team
            : $user->teams->first();

        if (! $team) {
            $user->update(['team_id' => null]);

            return $user->can('create', Team::class)
                ? to_action([TeamFirstController::class, 'create'])
                : to_action([TeamFirstController::class, 'required']);
        }

        // Select the first available team
        app(SelectUserTeam::class)->execute($user, $team);
        app(TeamService::class)->setCurrent($team);

        return $next($request);
    }
}
