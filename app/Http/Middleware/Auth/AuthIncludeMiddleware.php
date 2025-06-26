<?php

namespace App\Http\Middleware\Auth;

use App\Data\Team\TeamResource;
use App\Data\User\UserAbilitiesResource;
use App\Data\User\UserResource;
use App\Facades\Services;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class AuthIncludeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (! $user) {
            Inertia::share([
                'auth' => null,
            ]);

            return $next($request);
        }

        $user->loadMissing([
            'avatar',
            'teams.logo',
            'team.logo',
        ]);

        Inertia::share([
            'auth' => [
                'user'      => UserResource::from($user),
                'abilities' => UserAbilitiesResource::from($user),
                'team'      => TeamResource::from(Services::team()->current()),
            ],
        ]);

        return $next($request);
    }
}
