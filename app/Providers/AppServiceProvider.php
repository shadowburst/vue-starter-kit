<?php

namespace App\Providers;

use App\Services\ServicesManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
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
        Vite::prefetch(concurrency: 3);

        $this->app->singleton('services', fn () => new ServicesManager);

        Route::bind(
            'member',
            fn (string $value) => Auth::user()->members()
                ->withTrashed()
                ->findOrFail($value),
        );
    }
}
