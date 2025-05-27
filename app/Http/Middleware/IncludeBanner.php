<?php

namespace App\Http\Middleware;

use App\Data\Banner\BannerPageResource;
use App\Models\Banner;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class IncludeBanner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var ?\App\Models\User $user */
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        $banner = Banner::query()
            ->whereNot->whereAttachedTo($user)
            ->where([
                ['start_date', '<=', now()],
                ['end_date', '>=', now()],
            ])
            ->whereIsEnabled(true)
            ->first();

        if ($banner) {
            Inertia::share('banner', BannerPageResource::from($banner));
        }

        return $next($request);
    }
}
