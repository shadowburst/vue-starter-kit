<?php

namespace App\Providers;

use App\Http\Middleware\Team\SetTeamMiddleware;
use App\Services\ServicesManager;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $kernel = app()->make(Kernel::class);

        $kernel->addToMiddlewarePriorityBefore(
            SubstituteBindings::class,
            SetTeamMiddleware::class,
        );

        $this->app->singleton('services', fn () => new ServicesManager);
    }
}
