<?php

namespace App\Http\Middleware\Auth;

use App\Data\User\UserAuthResource;
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
        if ($user) {
            Inertia::share([
                'auth' => [
                    'user'      => UserAuthResource::from($user->loadMissing(['avatar', 'teams'])),
                    'abilities' => Services::abilities()->get(),
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
