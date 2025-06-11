<?php

namespace App\Http\Middleware\Auth;

use App\Facades\Services;
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
        if ($user->team_id && $user->teams->contains($user->team_id)) {
            // User already in a valid team
            Services::team()->setCurrent($user->team);

            return $next($request);
        }

        $team = $user->teams->first();

        if ($team) {
            // Select the first available team
            Services::user()->selectTeam->execute($user, $team);
            Services::team()->setCurrent($user->team);

            return $next($request);
        }

        if ($user->is_owner) {
            return to_route('teams.first.create');
        }

        return to_route('teams.first.required');
    }
}
