<?php

namespace App\Http\Middleware;

use App\Data\Banner\BannerAppResource;
use App\Models\Banner;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        Inertia::share([
            'banner' => fn () => $this->getBanner(),
        ]);

        return $next($request);
    }

    protected function getBanner(): ?BannerAppResource
    {
        /** @var ?\App\Models\User $user */
        $user = Auth::user();

        if (! $user) {
            return null;
        }

        $banner = Banner::query()
            ->whereNot->whereAttachedTo($user)
            ->whereIsEnabled(true)
            ->orderBy('id', 'desc')
            ->first();

        if (! $banner) {
            return null;
        }

        return BannerAppResource::from($banner);
    }
}
