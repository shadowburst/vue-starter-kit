<?php

namespace App\Http\Middleware\Auth;

use App\Data\Auth\AuthAbilitiesResource;
use App\Services\TeamService;
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
        Inertia::share([
            'auth' => [
                'abilities' => new AuthAbilitiesResource,
                'user'      => Auth::user()?->getData()?->include('avatar', 'teams.{id,name,logo}'),
                'team'      => app(TeamService::class)->current()?->getData(),
            ],
        ]);

        return $next($request);
    }
}
