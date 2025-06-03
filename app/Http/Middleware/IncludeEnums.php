<?php

namespace App\Http\Middleware;

use App\Enums\Trashed\TrashedFilter;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class IncludeEnums
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Inertia::share([
            'enums'                 => Inertia::merge([]),
            'enums.trashed_filters' => Inertia::optional(fn () => TrashedFilter::labels(), 'enums'),
        ]);

        return $next($request);
    }
}
