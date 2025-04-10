<?php

namespace App\Http\Middleware;

use App\Data\Auth\AuthUserResource;
use App\Models\User;
use App\Services\ToastService;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $toast = app(ToastService::class);

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => value(
                fn (?User $user) => ! $user ? null : [
                    'user' => AuthUserResource::from($user->load(['avatar'])),
                ],
                $request->user(),
            ),
            'toast' => $toast->get(),
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
        ];
    }
}
