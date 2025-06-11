<?php

namespace App\Http\Middleware\Auth;

use App\Data\User\UserAbilitiesResource;
use App\Data\User\UserResource;
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
        if ($user) {
            Inertia::share([
                'auth' => [
                    'user'      => UserResource::from($user->loadMissing(['avatar', 'teams'])),
                    'abilities' => UserAbilitiesResource::from($user),
                ],
            ]);
        } else {
            Inertia::share([
                'auth' => null,
            ]);
        }

        return $next($request);
    }
}
